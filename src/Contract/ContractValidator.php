<?php

namespace Metamorphose\Contract;

use Metamorphose\Output\FormatterCollection;

class ContractValidator {

    /** @var bool $strict */
    protected $strict = false;

    /** @var array $formats */
    protected $formats = [];

    /** @var ContractValidatorField[] $fields */
    protected $fields = [];

    public function __construct(string $filePath) {

        $this->parseFile($filePath);

    }

    /**
     * This only validate the output structure. Not the fields types or values. For that use DataValidators
     *
     * @param ContractInterface $contract
     * @param FormatterCollection $loadedFormatters
     *
     * @throws \Exception
     */
    public function validate(ContractInterface $contract, FormatterCollection $loadedFormatters) {

        if($this->strict) {

            $this->checkExpectedFormat($contract, $loadedFormatters);
            $this->checkForMissingFields($contract);
            $this->checkForAddedFields($contract);
            $this->checkFieldsOrder($contract);

        } else {

            $this->checkExpectedFormat($contract, $loadedFormatters);
            $this->checkForMissingFields($contract);

        }

    }

    protected function checkExpectedFormat(ContractInterface $contract, FormatterCollection $loadedFormatters) {

        // Validate that the expected output format is available
        $validOutputFormat = false;
        foreach ($contract->getFormatters() as $formatterName) {

            $formatter = $loadedFormatters->getFormatter($formatterName);

            if (in_array($formatter->getFormat(), $this->formats)) {

                $validOutputFormat = true;
                break;

            }

        }

        if (!$validOutputFormat) {

            throw new \Exception('The contract is not valid. It should at least support one of the expected output format: ' . implode(', ', $this->formats));

        }

    }

    protected function checkForMissingFields(ContractInterface $contract) {

        // Validate the final structure
        $contractFields = $contract->getFields();
        $validatorFields = $this->fields;
        $missingFields = [];

        foreach($validatorFields as $validatorField) {

            $fieldIsPresent = false;

            if(!$validatorField->isMandatory()) {
                continue;
            }

            foreach($contractFields as $contractField) {

                if($contractField->getTo() === $validatorField->getTo()) {

                    $fieldIsPresent = true;

                    break;

                }

            }

            if(!$fieldIsPresent) {

                $missingFields[] = $validatorField->getTo();

            }

        }

        if(!empty($missingFields)) {

            throw new \Exception('The contract is not valid. Missing fields: ' . implode(', ', $missingFields));

        }

    }

    protected function checkForAddedFields(ContractInterface $contract) {

        // Validate the final structure
        $contractFields = $contract->getFields();
        $validatorFields = $this->fields;
        $missingFields = [];

        foreach($contractFields as $contractField) {

            foreach($validatorFields as $validatorField) {

                if($contractField->getTo() === $validatorField->getTo()) {
                    continue 2;
                }

            }

            $missingFields[] = $contractField->getTo();

        }

        if(!empty($missingFields)) {

            throw new \Exception('The contract is not valid. Missing fields: ' . implode(', ', $missingFields));

        }

    }

    protected function checkFieldsOrder(ContractInterface $contract) {

        // Validate the final structure
        $contractFields = $contract->getFields();
        $validatorFields = $this->fields;

        foreach($validatorFields as $validatorFieldKey => $validatorField) {

            // Will work properly only if the optional fields are at the end
            if(!$validatorField->isMandatory()) {
                continue;
            }

            foreach($contractFields as $contractFieldKey => $contractField) {

                if(
                    $validatorFieldKey === $contractFieldKey
                    && $contractField->getTo() !== $validatorField->getTo()
                ) {

                    if(!empty($missingFields)) {

                        throw new \Exception('The contract is not valid. Wrong fields order, starting with: ' . $validatorField->getTo());

                    }

                }

            }

        }

    }

    protected function parseFile(string $filePath): void {

        $contractData = json_decode(file_get_contents($filePath), true);

        if(isset($contractData['strict'])) {

            $this->strict = $contractData['strict'];

        }

        if(isset($contractData['formats'])) {

            $this->formats = $contractData['formats'];

        } else {

            throw new \Exception('The contract needs to have at least one output formats');

        }

        if(isset($contractData['fields'])) {

            foreach($contractData['fields'] as $fieldData) {

                $this->fields[] = new ContractValidatorField($fieldData);

            }

        }

    }

}
