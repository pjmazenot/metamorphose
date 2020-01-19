<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Contract;

use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Output\FormatterCollection;

/**
 * Class ContractValidator
 *
 * @package Metamorphose\Contract
 */
class ContractValidator {

    /** @var bool $strict */
    protected $strict = false;

    /** @var array $formats */
    protected $formats = [];

    /** @var ContractValidatorField[] $fields */
    protected $fields = [];

    /**
     * ContractValidator constructor.
     *
     * @param string $filePath
     *
     * @throws MetamorphoseContractException
     */
    public function __construct(string $filePath) {

        $this->parseFile($filePath);

    }

    /**
     * Validate the contract
     * This only validate the output structure. Not the fields types or values. For those we need to use DataValidators.
     *
     * @param ContractInterface   $contract
     * @param FormatterCollection $loadedFormatters
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function validate(ContractInterface $contract, FormatterCollection $loadedFormatters): void {

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

    /**
     * Check that the target formatter supports the right format
     *
     * @param ContractInterface   $contract
     * @param FormatterCollection $loadedFormatters
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    protected function checkExpectedFormat(ContractInterface $contract, FormatterCollection $loadedFormatters): void {

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

            throw new MetamorphoseContractException('The contract is not valid. It should at least support one of the expected output format: ' . implode(', ', $this->formats));

        }

    }

    /**
     * Check for missing fields
     *
     * @param ContractInterface $contract
     *
     * @throws MetamorphoseContractException
     */
    protected function checkForMissingFields(ContractInterface $contract): void {

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

            throw new MetamorphoseContractException('The contract is not valid. Missing fields: ' . implode(', ', $missingFields));

        }

    }

    /**
     * Check for extra fields
     *
     * @param ContractInterface $contract
     *
     * @throws MetamorphoseContractException
     */
    protected function checkForAddedFields(ContractInterface $contract): void {

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

            throw new MetamorphoseContractException('The contract is not valid. Missing fields: ' . implode(', ', $missingFields));

        }

    }

    /**
     * Check that the fields are defined in the right order
     *
     * @param ContractInterface $contract
     *
     * @throws MetamorphoseContractException
     */
    protected function checkFieldsOrder(ContractInterface $contract): void {

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

                        throw new MetamorphoseContractException('The contract is not valid. Wrong fields order, starting with: ' . $validatorField->getTo());

                    }

                }

            }

        }

    }

    /**
     * Parse the contract validator definition file
     *
     * @param string $filePath
     *
     * @throws MetamorphoseContractException
     */
    protected function parseFile(string $filePath): void {

        $contractData = json_decode(file_get_contents($filePath), true);

        if(isset($contractData['strict'])) {

            $this->strict = $contractData['strict'];

        }

        if(isset($contractData['formats'])) {

            $this->formats = $contractData['formats'];

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one output formats');

        }

        if(isset($contractData['fields'])) {

            foreach($contractData['fields'] as $fieldData) {

                $this->fields[] = new ContractValidatorField($fieldData);

            }

        }

    }

}
