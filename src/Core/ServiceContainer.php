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

use Metamorphose\Contract\Contract;
use Metamorphose\Contract\ContractValidator;
use Metamorphose\Data\DataSet;
use Metamorphose\Data\DataSetCollection;
use Metamorphose\Data\Find\ReferenceLocator;
use Metamorphose\Data\Find\ReferenceLocatorCollection;
use Metamorphose\Data\Load\DestinationCollection;
use Metamorphose\Data\Load\DestinationInterface;
use Metamorphose\Data\Load\FormatterCollection;
use Metamorphose\Data\Load\FormatterInterface;
use Metamorphose\Data\Transform\ProcessorCollection;
use Metamorphose\Data\Transform\ProcessorInterface;
use Metamorphose\Data\Validate\ValidatorCollection;
use Metamorphose\Data\Validate\ValidatorInterface;
use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Data\Extract\SourceCollection;
use Metamorphose\Data\Extract\SourceInterface;
use Metamorphose\Data\Extract\ParserCollection;
use Metamorphose\Data\Extract\ParserInterface;

/**
 * Class ServiceContainer
 *
 * @package Metamorphose\Core
 */
class ServiceContainer {

    /** @var Contract $contract */
    protected $contract;

    /** @var ContractValidator|null $contractValidator */
    protected $contractValidator;

    /** @var ParserCollection $parserCollection */
    protected $parserCollection;

    /** @var ProcessorCollection $dataProcessorCollection */
    protected $dataProcessorCollection;

    /** @var ValidatorCollection $dataValidatorCollection */
    protected $dataValidatorCollection;

    /** @var FormatterCollection $outputFormatter */
    protected $formatterCollection;

    /** @var SourceCollection $dataSourceCollection */
    protected $dataSourceCollection;

    /** @var DestinationCollection $dataDestinationCollection */
    protected $dataDestinationCollection;

    /** @var DataSetCollection $dataSetCollection */
    protected $dataSetCollection;

    /** @var ReferenceLocatorCollection $referenceLocatorCollection */
    protected $referenceLocatorCollection;

    /**
     * MorphServices constructor.
     *
     * @param string      $inputContractFilePath
     * @param string|null $outputContractFilePath
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseDataSourceException
     */
    public function __construct(string $inputContractFilePath, string $outputContractFilePath = null) {

        $this->parserCollection = new ParserCollection();
        $this->dataProcessorCollection = new ProcessorCollection();
        $this->dataValidatorCollection = new ValidatorCollection();
        $this->formatterCollection = new FormatterCollection();
        $this->dataSetCollection = new DataSetCollection();
        $this->referenceLocatorCollection = new ReferenceLocatorCollection();

        // Init the contract
        $this->contract = new Contract($inputContractFilePath);

        // Init the contract validator and validate the contract right away
        if (isset($outputContractFilePath)) {

            $this->contractValidator = new ContractValidator($outputContractFilePath);

        }

        // Init data sources and destinations collections
        $this->dataSourceCollection = new SourceCollection();
        $this->dataDestinationCollection = new DestinationCollection();

    }

    /**
     * Get the contract
     *
     * @return Contract
     */
    public function getContract(): Contract {

        return $this->contract;

    }

    /**
     * Get the contract validator
     *
     * @return ContractValidator|null
     */
    public function getContractValidator(): ?ContractValidator {

        return $this->contractValidator;

    }

    /**
     * Validate the contract
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function validateContract(): void {

        if (!isset($this->contractValidator)) {

            throw new MetamorphoseUndefinedServiceException('The contract validator service is not defined');

        }

        $this->contractValidator->validate($this->contract, $this->formatterCollection);

    }

    /**
     * Get the parser collection
     *
     * @return ParserCollection
     */
    public function getParserCollection(): ParserCollection {

        return $this->parserCollection;

    }

    /**
     * Get the data processor collection
     *
     * @return ProcessorCollection
     */
    public function getDataProcessorCollection(): ProcessorCollection {

        return $this->dataProcessorCollection;

    }

    /**
     * Get the data validator collection
     *
     * @return ValidatorCollection
     */
    public function getDataValidatorCollection(): ValidatorCollection {

        return $this->dataValidatorCollection;

    }

    /**
     * Get the formatter collection
     *
     * @return FormatterCollection
     */
    public function getFormatterCollection(): FormatterCollection {

        return $this->formatterCollection;

    }

    /**
     * Get the data source collection
     *
     * @return SourceCollection
     */
    public function getDataSourceCollection(): SourceCollection {

        return $this->dataSourceCollection;

    }

    /**
     * Get the data destination collection
     *
     * @return DestinationCollection
     */
    public function getDataDestinationCollection(): DestinationCollection {

        return $this->dataDestinationCollection;

    }

    /**
     * Get the data set collection
     *
     * @return DataSetCollection
     */
    public function getDataSetCollection(): DataSetCollection {

        return $this->dataSetCollection;

    }

    /**
     * Get the reference locator collection
     *
     * @return ReferenceLocatorCollection
     */
    public function getReferenceLocatorCollection(): ReferenceLocatorCollection {

        return $this->referenceLocatorCollection;

    }

    /**
     * Register a parser
     *
     * @param ParserInterface $parser
     */
    public function registerParser(ParserInterface $parser): void {

        $this->parserCollection->registerParser($parser);

    }

    /**
     * Register a data processor
     *
     * @param ProcessorInterface $dataProcessor
     */
    public function registerDataProcessor(ProcessorInterface $dataProcessor): void {

        $this->dataProcessorCollection->registerDataProcessor($dataProcessor);

    }

    /**
     * Register a data validator
     *
     * @param ValidatorInterface $dataValidator
     */
    public function registerDataValidator(ValidatorInterface $dataValidator): void {

        $this->dataValidatorCollection->registerDataValidator($dataValidator);

    }

    /**
     * Register a formatter
     *
     * @param FormatterInterface $formatter
     */
    public function registerFormatter(FormatterInterface $formatter): void {

        $this->formatterCollection->registerFormatter($formatter);

    }

    /**
     * Register a data source
     *
     * @param string          $name
     * @param SourceInterface $dataSource
     */
    public function registerDataSource(string $name, SourceInterface $dataSource): void {

        $this->dataSourceCollection->registerDataSource($name, $dataSource);

    }

    /**
     * Register a data destination
     *
     * @param string               $name
     * @param DestinationInterface $dataDestination
     */
    public function registerDataDestination(string $name, DestinationInterface $dataDestination): void {

        $this->dataDestinationCollection->registerDataDestination($name, $dataDestination);

    }

    /**
     * Register a data set
     *
     * @param string  $name
     * @param DataSet $dataSet
     */
    public function registerDataSet(string $name, DataSet $dataSet): void {

        $this->dataSetCollection->registerDataSet($name, $dataSet);

    }

    /**
     * Register a data locator
     *
     * @param string           $name
     * @param ReferenceLocator $referenceLocator
     */
    public function registerReferenceLocator(string $name, ReferenceLocator $referenceLocator): void {

        $this->referenceLocatorCollection->registerReferenceLocator($name, $referenceLocator);

    }

}