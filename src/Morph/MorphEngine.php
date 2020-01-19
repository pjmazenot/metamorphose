<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Morph;

use Metamorphose\Contract\Contract;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Exceptions\MetamorphoseValidateException;

/**
 * Class MorphEngine
 *
 * @package Metamorphose\Morph
 */
class MorphEngine {

    const SOURCE_TYPE_ARRAY = 'array';
    const SOURCE_TYPE_FILE = 'file';
    const SOURCE_TYPE_STRING = 'string';

    /** @var MorphServices $services */
    protected $services;

    /** @var string $sourceType */
    protected $sourceType;

    /** @var string|array $source */
    protected $source;

    /** @var DataSet $convertedData */
    protected $convertedData;

    /**
     * MorphEngine constructor.
     *
     * @param string      $inputContractFilePath
     * @param string|null $outputContractFilePath
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function __construct(string $inputContractFilePath, ?string $outputContractFilePath = null) {

        $this->services = new MorphServices($inputContractFilePath, $outputContractFilePath);

    }

    /**
     * Get the service container
     *
     * @return MorphServices
     */
    public function getServices() {

        return $this->services;

    }
    /**
     * Set the source data
     *
     * @param string $sourceType
     * @param string $source
     */
    public function load(string $sourceType, string $source) {

        $this->sourceType = $sourceType;
        $this->source = $source;

    }

    // @TODO: Buffer (nbItem) - for CSV for example or JSON/XML collections

    /**
     * Main transform function
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    public function convert() {

        // Check that the source is set
        if(empty($this->sourceType) || empty($this->source)) {

            throw new MetamorphoseException('Missing source');

        }

        // Create the data set from the input data
        switch ($this->sourceType) {

            case self::SOURCE_TYPE_ARRAY:

                $this->services->getParser()->parseArray($this->source);
                break;

            case self::SOURCE_TYPE_FILE:

                $this->services->getParser()->parseFile($this->source);
                break;

            case self::SOURCE_TYPE_STRING:
            default:

                $this->services->getParser()->parseString($this->source);
                break;

        }

        // Transform using the contract
        $this->applyContract();

    }

    /**
     * Get the transformed and formatted data
     *
     * @return string
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getOutput() {

        return $this->services->getFormatter()->format($this->convertedData->getData()->toArray(), $this->services->getContract()->getOptions());

    }

    /**
     * Transform the data based on the provided contract
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    public function applyContract() {

        if($this->services->getContract()->getType() === Contract::TYPE_COLLECTION) {

            $convertedItems = [];
            $count = $this->services->getParser()->getParsedData()->getCount();

            for($i = 0; $i < $count; $i++) {

                $convertedItems[] = $this->processObject($i);

            }

            $this->convertedData = new DataSet($convertedItems);

        } else {

            $this->convertedData = new DataSet($this->processObject());

        }

    }

    /**
     * Transform one item
     *
     * @param int|null $key
     *
     * @return array
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    protected function processObject(?int $key = null) {

        $dataHolder = new DataSet();

        // We may need a prefix to get the right object when we process collections (when $key is set)
        $prefix = isset($key) ? $key . '.' : '';

        foreach($this->services->getContract()->getFields() as $field) {

            // Grab the content from the source data
            $value = $this->services->getParser()->getParsedData()->get($prefix . $field->getFrom());

            // Process the value
            $processedValue = $value;
            foreach($field->getProcessors() as $processorData) {

                $processorDataParts = explode(':', $processorData);
                $processorName = $processorDataParts[0];
                $processorParams = !empty($processorDataParts[1]) ? explode('|', str_replace(['{', '}'], '', $processorDataParts[1])) : [];

                $processor = $this->services->getDataProcessorCollection()->getDataProcessor($processorName);

                $processedValue = $processor->process($value, $processorParams);

            }

            // Validate the value
            foreach($field->getValidators() as $validatorData) {

                $validatorDataParts = explode(':', $validatorData);
                $validatorName = $validatorDataParts[0];
                $validatorParams = !empty($processorDataParts[1]) ? explode('|', str_replace(['{', '}'], '', $validatorDataParts[1])) : [];

                $validator = $this->services->getDataValidatorCollection()->getDataValidator($validatorName);

                $isValid = $validator->validate($value, $validatorParams);

                if(!$isValid) {
                    throw new MetamorphoseValidateException('Invalid value for the target field ' . $field->getTo());
                }

            }

            // Set the final value
            $dataHolder->set($field->getTo(), $processedValue);

        }

        return $dataHolder->getData()->toArray();

    }

}