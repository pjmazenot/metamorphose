<?php

namespace Metamorphose\Contract;

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
     *
     * @throws \Exception
     */
    public function validate(ContractInterface $contract) {


        if($this->strict) {
            // @TODO
            // Strict check exact match vs one of the matches - additional fields?
            // Check order of the fields?
        } else {

            $this->validateDefault($contract);

        }

    }

    protected function validateDefault(ContractInterface $contract) {

        // Only validate outputs
        // @TODO: Validate that the expected output format is available


        // Validate the final structure
        $contractFields = $contract->getFields();
        $validatorFields = $this->fields;
        $missingFields = [];

        foreach($validatorFields as $validatorField) {

            $fieldIsPresent = false;

            // @TODO: Keep?
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

    protected function parseFile(string $filePath): void {

        $contractData = json_decode(file_get_contents($filePath), true);

        if(isset($contractData['strict'])) {

            $this->strict = $contractData['strict'];

        }

        if(isset($contractData['formatters'])) {

            $this->formats = $contractData['formatters'];

        } else {

            throw new \Exception('The contract needs to have at least one formatter');

        }

        if(isset($contractData['fields'])) {

            foreach($contractData['fields'] as $fieldData) {

                $this->fields[] = new ContractValidatorField($fieldData);

            }

        }

    }

}
