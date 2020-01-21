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
use Metamorphose\Contract\ContractValidator;
use Metamorphose\Data\DataProcessorCollection;
use Metamorphose\Data\DataProcessorInterface;
use Metamorphose\Data\DataValidatorCollection;
use Metamorphose\Data\DataValidatorInterface;
use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Input\DataSourceCollection;
use Metamorphose\Input\DataSourceInterface;
use Metamorphose\Input\ParserCollection;
use Metamorphose\Input\ParserInterface;
use Metamorphose\Output\DataDestinationCollection;
use Metamorphose\Output\DataDestinationInterface;
use Metamorphose\Output\FormatterCollection;
use Metamorphose\Output\FormatterInterface;

/**
 * Class MorphServices
 *
 * @package Metamorphose\Morph
 */
class MorphServices {

    /** @var Contract $contract */
    protected $contract;

    /** @var ContractValidator|null $contractValidator */
    protected $contractValidator;

    /** @var ParserCollection $parserCollection */
    protected $parserCollection;

    /** @var DataProcessorCollection $dataProcessorCollection */
    protected $dataProcessorCollection;

    /** @var DataValidatorCollection $dataValidatorCollection */
    protected $dataValidatorCollection;

    /** @var FormatterCollection $outputFormatter */
    protected $formatterCollection;

    /** @var DataSourceCollection $dataSourceCollection */
    protected $dataSourceCollection;

    /** @var DataDestinationCollection $dataDestinationCollection */
    protected $dataDestinationCollection;

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
        $this->dataProcessorCollection = new DataProcessorCollection();
        $this->dataValidatorCollection = new DataValidatorCollection();
        $this->formatterCollection = new FormatterCollection();

        // Init the contract
        $this->contract = new Contract($inputContractFilePath);

        // Init the contract validator and validate the contract right away
        if(isset($outputContractFilePath)) {

            $this->contractValidator = new ContractValidator($outputContractFilePath);

        }

        // Init data sources and destinations collections
        $this->dataSourceCollection = new DataSourceCollection();
        $this->dataDestinationCollection = new DataDestinationCollection();

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

        if(!isset($this->contractValidator)) {

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
     * @return DataProcessorCollection
     */
    public function getDataProcessorCollection(): DataProcessorCollection {

        return $this->dataProcessorCollection;

    }

    /**
     * Get the data validator collection
     *
     * @return DataValidatorCollection
     */
    public function getDataValidatorCollection(): DataValidatorCollection {

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
     * @return DataSourceCollection
     */
    public function getDataSourceCollection(): DataSourceCollection {

        return $this->dataSourceCollection;

    }

    /**
     * Get the data destination collection
     *
     * @return DataDestinationCollection
     */
    public function getDataDestinationCollection(): DataDestinationCollection {

        return $this->dataDestinationCollection;

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
     * @param DataProcessorInterface $dataProcessor
     */
    public function registerDataProcessor(DataProcessorInterface $dataProcessor): void {

        $this->dataProcessorCollection->registerDataProcessor($dataProcessor);

    }

    /**
     * Register a data validator
     *
     * @param DataValidatorInterface $dataValidator
     */
    public function registerDataValidator(DataValidatorInterface $dataValidator): void {

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
     * @param string $name
     * @param DataSourceInterface $dataSource
     */
    public function registerDataSource(string $name, DataSourceInterface $dataSource): void {

        $this->dataSourceCollection->registerDataSource($name, $dataSource);

    }

    /**
     * Register a data destination
     *
     * @param string $name
     * @param DataDestinationInterface $dataDestination
     */
    public function registerDataDestination(string $name, DataDestinationInterface $dataDestination): void {

        $this->dataDestinationCollection->registerDataDestination($name, $dataDestination);

    }

}