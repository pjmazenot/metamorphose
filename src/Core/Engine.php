<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Core;

use Metamorphose\Contract\Definitions\ContractApplyDefinition;
use Metamorphose\Contract\Definitions\ContractAttributeDefinition;
use Metamorphose\Contract\Definitions\ContractFieldDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Data\Find\ReferenceLocator;
use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;
use Metamorphose\Exceptions\MetamorphoseParserException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Exceptions\MetamorphoseValidateException;

/**
 * Class Engine
 *
 * @package Metamorphose\Core
 */
class Engine {

    const STEP_EXTRACT = 'extract';
    const STEP_TRANSFORM = 'transform';
    const STEP_LOAD = 'load';
    const STEP_DONE = 'done';

    /** @var ServiceContainer $services */
    protected $services;

    /** @var string $nextStep */
    protected $nextStep;

    /**
     * MorphEngine constructor.
     *
     * @param string      $inputContractFilePath
     * @param string|null $outputContractFilePath
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseDataSourceException
     */
    public function __construct(string $inputContractFilePath, ?string $outputContractFilePath = null) {

        $this->services = new ServiceContainer($inputContractFilePath, $outputContractFilePath);

        $this->nextStep = self::STEP_EXTRACT;

    }

    /**
     * Get the service container
     *
     * @return ServiceContainer
     */
    public function getServices() {

        return $this->services;

    }

    /**
     * Extract the source data
     *
     * @param array $sourcesDynamicOptions
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseException
     * @throws MetamorphoseParserException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function extract(array $sourcesDynamicOptions): void {

        if ($this->nextStep !== self::STEP_EXTRACT) {

            throw new MetamorphoseException('Data already loaded');

        }

        // First validate the contract if a validator is available
        $contractValidator = $this->services->getContractValidator();
        if (!empty($contractValidator)) {

            $this->services->validateContract();

        }

        // Check that the source is set
        foreach ($this->services->getContract()->getSources() as $sourceDefinition) {

            $sourceName = $sourceDefinition->getName();
            $sourceType = $sourceDefinition->getType();
            $parserName = $sourceDefinition->getParser();

            // Update the options if dynamic options are provided
            if (!empty($sourcesDynamicOptions[$sourceName])) {

                $sourceDefinition->setDynamicOptions($sourcesDynamicOptions[$sourceName]);

            }

            // Get the parser if provided
            $parser = null;
            if (isset($parserName)) {

                $parser = $this->services->getParserCollection()->getParser($parserName);

            }

            // Register the data source
            $this->services->getDataSourceCollection()->registerDataSourceFromModel($sourceType, $sourceName);

            // Extract the data
            $dataSource = $this->services->getDataSourceCollection()->getDataSource($sourceName);
            $dataSet = $dataSource->extract($sourceDefinition, $parser);

            // Register the data set
            $this->services->getDataSetCollection()->registerDataSet($sourceName, $dataSet);

        }

        $this->nextStep = self::STEP_TRANSFORM;

    }

    /**
     * Main transform function
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    public function transform() {

        if ($this->nextStep === self::STEP_EXTRACT) {

            throw new MetamorphoseException('Data not extracted');

        } elseif ($this->nextStep === self::STEP_LOAD) {

            throw new MetamorphoseException('Data already transformed');

        }

        // Pre-process the data directly at the source
        foreach ($this->services->getContract()->getSources() as $sourceDefinition) {

            // Get the source data set
            $dataSet = $this->services->getDataSetCollection()->getDataSet($sourceDefinition->getName());

            // Process fields
            foreach ($sourceDefinition->getFields() as $sourceFieldDefinition) {

                $this->processField(
                    $sourceFieldDefinition,
                    $dataSet
                );

            }

        }

        // Process the data to create the destinations
        foreach ($this->services->getContract()->getDestinations() as $destinationDefinition) {

            // Register the destination and get the data set
            $this->services->getDataDestinationCollection()->registerDataDestinationFromModel($destinationDefinition->getType(), $destinationDefinition->getName());
            $this->services->getDataSetCollection()->registerDataSet($destinationDefinition->getName(), new DataSet());
            $dataSet = $this->services->getDataSetCollection()->getDataSet($destinationDefinition->getName());

            foreach ($destinationDefinition->getFields() as $destinationFieldDefinition) {

                $this->processField(
                    $destinationFieldDefinition,
                    $dataSet
                );

            }

        }

        $this->nextStep = self::STEP_LOAD;

    }

    /**
     * Get the transformed and formatted data
     *
     * @param array $destinationsDynamicOptions
     *
     * @return array
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseException
     * @throws MetamorphoseFormatterException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function load(array $destinationsDynamicOptions): array {

        if ($this->nextStep === self::STEP_EXTRACT) {

            throw new MetamorphoseException('Data not extracted');

        } elseif ($this->nextStep === self::STEP_TRANSFORM) {

            throw new MetamorphoseException('Data not transformed');

        }

        $return = [];
        foreach ($this->services->getContract()->getDestinations() as $destinationDefinition) {

            $destinationName = $destinationDefinition->getName();
            $formatterName = $destinationDefinition->getFormatter();

            // Update the options if dynamic options are provided
            if (!empty($destinationsDynamicOptions[$destinationName])) {

                $destinationDefinition->setDynamicOptions($destinationsDynamicOptions[$destinationName]);

            }

            // Get the parser if provided
            $formatter = null;
            if (isset($formatterName)) {

                $formatter = $this->services->getFormatterCollection()->getFormatter($formatterName);

            }

            // Load the data
            $dataDestination = $this->services->getDataDestinationCollection()->getDataDestination($destinationName);
            $dataSet = $this->services->getDataSetCollection()->getDataSet($destinationName);
            $return[$destinationName] = $dataDestination->load($dataSet, $destinationDefinition, $formatter);

        }

        $this->nextStep = self::STEP_DONE;

        return $return;

    }

    /**
     * Process a field
     *
     * @TODO: Move the processes to their own class?
     *
     * @param ContractFieldDefinition $fieldDefinition
     * @param DataSet                 $dataSet
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processField(ContractFieldDefinition $fieldDefinition, DataSet $dataSet) {

        $fieldApply = $fieldDefinition->getApply();
        $fieldAttributes = $fieldDefinition->getAttributes();

        if (!empty($fieldApply)) {

            // Apply
            $this->processFieldApply($fieldDefinition, $dataSet, null);

        }

        // Process attributes
        if (!empty($fieldAttributes)) {

            foreach ($fieldAttributes as $attributeDefinition) {

                $this->processFieldAttributeApply($fieldDefinition, $attributeDefinition, $dataSet, null);

            }

        }

    }

    /**
     * Process the apply list of a field
     *
     * @param ContractFieldDefinition $fieldDefinition
     * @param DataSet                 $dataSet
     * @param mixed                   $value
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processFieldApply(ContractFieldDefinition $fieldDefinition, DataSet $dataSet, $value): void {

        $this->processApply($fieldDefinition->getApply(), $fieldDefinition->getName(), $dataSet, $value);

    }

    /**
     * Process the apply list of an attribute
     *
     * @param ContractFieldDefinition     $fieldDefinition
     * @param ContractAttributeDefinition $attributeDefinition
     * @param DataSet                     $dataSet
     * @param mixed                       $value
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processFieldAttributeApply(ContractFieldDefinition $fieldDefinition, ContractAttributeDefinition $attributeDefinition, DataSet $dataSet, $value): void {

        $this->processApply($attributeDefinition->getApply(), $fieldDefinition->getName() . '@' . $attributeDefinition->getName(), $dataSet, $value);

    }

    /**
     * Process the apply list
     *
     * @param array   $apply
     * @param string  $name
     * @param DataSet $dataSet
     * @param mixed   $value
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processApply(array $apply, string $name, DataSet $dataSet, $value): void {

        foreach ($apply as $applyIndex => $applyDefinition) {

            $maxIndexes = [
                'g' => 0,
            ];

            // Set this to false to start the process
            $isDoneProcessing = false;

            // End the process if everything has been processed
            while (!$isDoneProcessing) {

                // Set this to true - If a collection is being processed it'll update the status
                $isDoneProcessing = true;

                // Get the params
                $params = $applyDefinition->getArgs();

                // Process each params (retrieve reference if available)
                foreach ($params as $paramIndex => &$param) {

                    // Generate the reference locator key
                    $referenceLocatorName = md5($name . $applyIndex . $paramIndex . (string)$param);

                    // Retrieve the current reference locator if it is registered
                    $referenceLocator = $this->services->getReferenceLocatorCollection()->getReferenceLocator($referenceLocatorName);

                    // Init and register the reference locator if empty
                    if (!isset($referenceLocator)) {

                        $referenceLocator = new ReferenceLocator($param);
                        $this->services->getReferenceLocatorCollection()->registerReferenceLocator($referenceLocatorName, $referenceLocator);

                    }

                    // Update the param value if it was a reference
                    if ($referenceLocator->isReference()) {

                        // Get the next reference available in the reference locator
                        $reference = $referenceLocator->getNextReference($this->services->getDataSetCollection());

                        // Update the reference string in the param with the reference value
                        $param = $reference->getValue();

                        if (!$referenceLocator->isDone()) {

                            // Prevent the process to break out of the loop if we have other references to process
                            $isDoneProcessing = false;

                        }

                        // Save the highest index set (default) to be able to generate the final field key later
                        $referenceIndexes = $reference->getIndexes();
                        if (isset($referenceIndexes['g']) && $referenceIndexes['g'] >= $maxIndexes['g']) {

                            $maxIndexes = $referenceIndexes;

                        }

                    }

                }

                if ($applyDefinition->getType() === ContractApplyDefinition::TYPE_PROCESSOR) {

                    // Get the processor by name
                    $processor = $this->services->getDataProcessorCollection()->getDataProcessor($applyDefinition->getName());

                    // If value = null try to get key first (this should only work in the case of a source since the
                    // destination is supposed to be empty for now)
                    if (!isset($value)) {

                        $value = $dataSet->get($name);

                    }

                    // Apply the processor
                    $value = $processor->process($value, $params);

                    // Generate the final key
                    $fieldKey = $name;
                    foreach ($maxIndexes as $level => $index) {

                        $fieldKey = str_replace('[$' . $level . ']', $index, $fieldKey);

                    }

                    // Set the final value
                    $dataSet->set($fieldKey, $value);

                } elseif ($applyDefinition->getType() === ContractApplyDefinition::TYPE_VALIDATOR) {

                    // Get the validator by name
                    $validator = $this->services->getDataValidatorCollection()->getDataValidator($applyDefinition->getName());

                    // If value = null try to get key directly (this should only work in the case of a source since the
                    // destination is supposed to be empty for now)
                    if (!isset($value)) {

                        $value = $dataSet->get($name);

                    }

                    // Apply the validator
                    $isValid = $validator->validate($value, $params);

                    if (!$isValid) {
                        throw new MetamorphoseValidateException('Invalid value for the target field or attribute ' . $name);
                    }

                } else {

                    throw new MetamorphoseException('Invalid apply type for ' . $name);

                }

            }

        }

    }

}