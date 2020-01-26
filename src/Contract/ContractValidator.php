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

use Metamorphose\Data\Load\FormatterCollection;
use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class ContractValidator
 *
 * @package Metamorphose\Contract
 */
class ContractValidator {

    /** @var bool $strict */
    protected $strict = false;

    /** @var ContractValidatorDestination[] $destinations */
    protected $destinations = [];

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

        $contractDestinations = $contract->getDestinations();
        $invalidDestinations = [];
        foreach ($this->destinations as $key => $validatorDestination) {

            if(empty($contractDestinations[$key])) {

                throw new MetamorphoseContractException('Contract destinations don\'t match the validator');

            }

            $contractDestination = $contractDestinations[$key];

            $formatter = $loadedFormatters->getFormatter($contractDestination->getFormatter());

            if (in_array($formatter->getFormat(), $validatorDestination->getFormats())) {

                continue;

            }

            $invalidDestinations[] = $key;

        }

        if (!empty($invalidDestinations)) {

            throw new MetamorphoseContractException('The contract is not valid. The following destinations (index) don\'t provide the right data type: ' . implode(', ', $invalidDestinations));

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

        $contractDestinations = $contract->getDestinations();
        $missingFields = [];
        foreach ($this->destinations as $key => $validatorDestination) {

            if(empty($contractDestinations[$key])) {

                throw new MetamorphoseContractException('Contract destinations don\'t match the validator');

            }

            $contractDestination = $contractDestinations[$key];
            $contractFields = $contractDestination->getFields();
            $validatorFields = $validatorDestination->getFields();

            foreach($validatorFields as $validatorField) {

                $fieldIsPresent = false;

                if(!$validatorField->isMandatory()) {
                    continue;
                }

                foreach($contractFields as $contractField) {

                    if($contractField->getName() === $validatorField->getName()) {

                        $fieldIsPresent = true;

                        break;

                    }

                }

                if(!$fieldIsPresent) {

                    $missingFields[] = $key . '.' . $validatorField->getName();

                }

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

        $contractDestinations = $contract->getDestinations();
        $addedFields = [];
        foreach ($this->destinations as $key => $validatorDestination) {

            if(empty($contractDestinations[$key])) {

                throw new MetamorphoseContractException('Contract destinations don\'t match the validator');

            }

            $contractDestination = $contractDestinations[$key];
            $contractFields = $contractDestination->getFields();
            $validatorFields = $validatorDestination->getFields();

            foreach($contractFields as $contractField) {

                foreach($validatorFields as $validatorField) {

                    if($contractField->getName() === $validatorField->getName()) {

                        continue 2;

                    } else {

                        $addedFields[] = $contractDestination->getName() . '.' . $contractField->getName();

                    }

                }

            }

        }

        if(!empty($addedFields)) {

            throw new MetamorphoseContractException('The contract is not valid. Added fields: ' . implode(', ', $addedFields));

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

        $contractDestinations = $contract->getDestinations();
        $missingFields = [];
        foreach ($this->destinations as $key => $validatorDestination) {

            if(empty($contractDestinations[$key])) {

                throw new MetamorphoseContractException('Contract destinations don\'t match the validator');

            }

            $contractDestination = $contractDestinations[$key];
            $contractFields = $contractDestination->getFields();
            $validatorFields = $validatorDestination->getFields();

            foreach($validatorFields as $validatorFieldKey => $validatorField) {

                // Will work properly only if the optional fields are at the end
                if(!$validatorField->isMandatory()) {
                    continue;
                }

                foreach($contractFields as $contractFieldKey => $contractField) {

                    if(
                        $validatorFieldKey === $contractFieldKey
                        && $contractField->getTo() !== $validatorField->getName()
                    ) {

                        throw new MetamorphoseContractException('The contract is not valid. Wrong fields order, starting with: ' . $validatorField->getName());

                    }

                }

            }

        }

        if(!empty($missingFields)) {

            throw new MetamorphoseContractException('The contract is not valid. Missing fields: ' . implode(', ', $missingFields));

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

        if(isset($contractData['destinations'])) {

            foreach($contractData['destinations'] as $destinationData) {

                $this->destinations[] = new ContractValidatorDestination($destinationData);

            }

        }

    }

}
