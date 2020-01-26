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

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Contract\Definitions\ContractApplyDefinition;
use Metamorphose\Contract\Definitions\ContractSourceDefinition;
use Metamorphose\Data\DataPoint;
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
     * Get the value by reference
     *
     * @param string $ref
     * @param int    $index
     *
     * @return DataPoint|mixed
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getReference(string $ref, ?int $index = null) {

        $fieldKeyParts = explode('.', $ref);
        $sourceName = str_replace('$ref:', '', array_shift($fieldKeyParts));
        if (isset($index)) {
            array_unshift($fieldKeyParts, $index);
        }
        $fieldKey = implode('.', $fieldKeyParts);

        return $this->services->getDataSourceCollection()->getDataSource($sourceName)->getData()->get($fieldKey);

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
            $dataSource->extract($sourceDefinition, $parser);

        }

        $this->nextStep = self::STEP_TRANSFORM;

    }

    // @TODO: Buffer (nbItem) - for CSV for example or JSON/XML collections

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

        $maxItemsCount = 1;

        // Pre-process the data directly at the source
        foreach ($this->services->getContract()->getSources() as $sourceDefinition) {

            $sourceName = $sourceDefinition->getName();
            $source = $this->services->getDataSourceCollection()->getDataSource($sourceName);

            if ($sourceDefinition->getStructure() === ContractSourceDefinition::STRUCTURE_COLLECTION) {

                $isCollection = true;
                $itemCount = $source->getData()->getCount();

            } else {

                $isCollection = false;
                $itemCount = 1;

            }

            if ($itemCount > $maxItemsCount) {

                $maxItemsCount = $itemCount;

            }

            for ($i = 0; $i < $itemCount; $i++) {

                // Process fields
                foreach ($sourceDefinition->getFields() as $sourceFieldDefinition) {

                    $collectionIndex = ($isCollection ? $i : null);
                    $fieldKey = ($isCollection ? $i . '.' : '') . $sourceFieldDefinition->getName();
                    $fieldApply = $sourceFieldDefinition->getApply();
                    $fieldAttributes = $sourceFieldDefinition->getAttributes();

                    if (!empty($fieldApply)) {

                        // Apply
                        $value = $source->getData()->get($fieldKey);
                        $value = $this->processApply($sourceFieldDefinition->getName(), $value, $fieldApply, $collectionIndex);

                        $source->getData()->set($fieldKey, $value);

                    }

                    // Process attributes
                    if (!empty($fieldAttributes)) {

                        foreach ($fieldAttributes as $attributeDefinition) {

                            $attributeKey = $fieldKey . '@' . $attributeDefinition->getName();
                            $attributeApply = $attributeDefinition->getApply();

                            if (!empty($attributeApply)) {

                                // Apply
                                $value = $source->getData()->get($attributeKey);
                                $value = $this->processApply($attributeDefinition->getName(), $value, $attributeApply, $collectionIndex);

                                $source->getData()->set($attributeKey, $value);

                            }

                        }

                    }

                }

            }

        }

        // Process the data to create the destinations
        foreach ($this->services->getContract()->getDestinations() as $destinationDefinition) {

            $this->services->getDataDestinationCollection()->registerDataDestinationFromModel($destinationDefinition->getType(), $destinationDefinition->getName());
            $dataDestination = $this->services->getDataDestinationCollection()->getDataDestination($destinationDefinition->getName());

            if ($destinationDefinition->getStructure() === ContractDestinationDefinition::STRUCTURE_COLLECTION) {

                $isCollection = true;

            } else {

                $isCollection = false;

            }

            for ($i = 0; $i < $maxItemsCount; $i++) {

                foreach ($destinationDefinition->getFields() as $destinationFieldDefinition) {

                    $collectionIndex = ($isCollection ? $i : null);
                    $fieldKey = ($isCollection ? $i . '.' : '') . $destinationFieldDefinition->getName();
                    $fieldApply = $destinationFieldDefinition->getApply();
                    $fieldAttributes = $destinationFieldDefinition->getAttributes();

                    if (!empty($fieldApply)) {

                        // Apply
                        $value = $this->processApply($destinationFieldDefinition->getName(), null, $fieldApply, $collectionIndex);

                        $dataDestination->getData()->set($fieldKey, $value);

                    }

                    // Process attributes
                    if (!empty($fieldAttributes)) {

                        foreach ($fieldAttributes as $attributeDefinition) {

                            $attributeKey = $fieldKey . '@' . $attributeDefinition->getName();
                            $attributeApply = $attributeDefinition->getApply();

                            if (!empty($attributeApply)) {

                                // Apply
                                $value = $this->processApply($attributeDefinition->getName(), null, $attributeApply, $collectionIndex);

                                $dataDestination->getData()->set($attributeKey, $value);

                            }

                        }

                    }

                }

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
            $return[$destinationName] = $dataDestination->load($dataDestination->getData(), $destinationDefinition, $formatter);

        }

        $this->nextStep = self::STEP_DONE;

        return $return;

    }

    /**
     * Process a field
     *
     * @param string                    $name
     * @param mixed                     $value
     * @param ContractApplyDefinition[] $apply
     * @param int                       $index
     *
     * @return mixed
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processApply(string $name, $value, array $apply, int $index = null) {

        foreach ($apply as $applyDefinition) {

            switch ($applyDefinition->getType()) {

                case ContractApplyDefinition::TYPE_VALUE:

                    if (is_string($applyDefinition->getValue()) && strpos($applyDefinition->getValue(), '$ref:') === 0) {
                        $value = $this->getReference($applyDefinition->getValue(), $index);
                    } else {
                        $value = $applyDefinition->getValue();
                    }
                    break;

                case ContractApplyDefinition::TYPE_PROCESSOR:
                case ContractApplyDefinition::TYPE_VALIDATOR:

                    $applyName = $applyDefinition->getName();
                    $params = $applyDefinition->getArgs();

                    foreach ($params as &$param) {

                        if (strpos($param, '$ref:') === 0) {
                            $param = $this->getReference($param, $index);
                        }

                    }

                    if ($applyDefinition->getType() === ContractApplyDefinition::TYPE_PROCESSOR) {

                        $processor = $this->services->getDataProcessorCollection()->getDataProcessor($applyName);

                        $value = $processor->process($value, $params);

                    } else {

                        $validator = $this->services->getDataValidatorCollection()->getDataValidator($applyName);

                        $isValid = $validator->validate($value, $params);

                        if (!$isValid) {
                            throw new MetamorphoseValidateException('Invalid value for the target field or attribute ' . $name);
                        }

                    }

                    break;

            }

        }

        return $value;

    }

}