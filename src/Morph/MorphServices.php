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
use Metamorphose\Input\ParserCollection;
use Metamorphose\Input\ParserInterface;
use Metamorphose\Output\FormatterCollection;
use Metamorphose\Output\FormatterInterface;

class MorphServices {

    /** @var Contract $contract */
    protected $contract;

    /** @var ContractValidator $contractValidator */
    protected $contractValidator;

    /** @var ParserCollection $parserCollection */
    protected $parserCollection;

    /** @var DataProcessorCollection $dataProcessorCollection */
    protected $dataProcessorCollection;

    /** @var DataValidatorCollection $dataValidatorCollection */
    protected $dataValidatorCollection;

    /** @var FormatterCollection $outputFormatter */
    protected $formatterCollection;

    /** @var ParserInterface $parser */
    protected $parser;

    /** @var FormatterInterface $parser */
    protected $formatter;

    public function __construct(string $inputContractFilePath, string $outputContractFilePath = null) {

        $this->parserCollection = new ParserCollection();
        $this->dataProcessorCollection = new DataProcessorCollection();
        $this->dataValidatorCollection = new DataValidatorCollection();
        $this->formatterCollection = new FormatterCollection();

        $this->contract = new Contract($inputContractFilePath);

        if(isset($outputContractFilePath)) {

            // Init the contract validator and validate the contract right away
            $this->contractValidator = new ContractValidator($outputContractFilePath);
            $this->contractValidator->validate($this->contract, $this->formatterCollection);

        }

    }

    /**
     * @return Contract
     */
    public function getContract(): Contract {

        return $this->contract;

    }

    /**
     * @return ContractValidator
     */
    public function getContractValidator(): ContractValidator {

        return $this->contractValidator;

    }

    /**
     * @return ParserCollection
     */
    public function getParserCollection(): ParserCollection {

        return $this->parserCollection;

    }

    /**
     * @return DataProcessorCollection
     */
    public function getDataProcessorCollection(): DataProcessorCollection {

        return $this->dataProcessorCollection;

    }

    /**
     * @return DataValidatorCollection
     */
    public function getDataValidatorCollection(): DataValidatorCollection {

        return $this->dataValidatorCollection;

    }

    /**
     * @return FormatterCollection
     */
    public function getFormatterCollection(): FormatterCollection {

        return $this->formatterCollection;

    }

    /**
     * @return ParserInterface
     */
    public function getParser(): ParserInterface {

        if(!isset($this->parser)) {

            // Load the default parser if none have been specified yet
            $defaultParserName = $this->contract->getDefaultParserName();
            $this->useParser($defaultParserName);

        }

        return $this->parser;

    }

    /**
     * @return FormatterInterface
     */
    public function getFormatter(): FormatterInterface {

        if(!isset($this->formatter)) {

            // Load the default formatter if none have been specified yet
            $defaultFormatterName = $this->contract->getDefaultFormatterName();
            $this->useFormatter($defaultFormatterName);

        }

        return $this->formatter;

    }

    public function registerParser(ParserInterface $parser): void {

        $this->parserCollection->registerParser($parser);

    }

    public function registerDataProcessor(DataProcessorInterface $dataProcessor): void {

        $this->dataProcessorCollection->registerDataProcessor($dataProcessor);

    }

    public function registerDataValidator(DataValidatorInterface $dataValidator): void {

        $this->dataValidatorCollection->registerDataValidator($dataValidator);

    }

    public function registerFormatter(FormatterInterface $formatter): void {

        $this->formatterCollection->registerFormatter($formatter);

    }

    public function useParser(string $name) {

        $this->contract->isParserAuthorizedOrThrow($name);

        $this->parser = $this->parserCollection->getParser($name);

    }

    public function useFormatter(string $name) {

        $this->contract->isFormatterAuthorizedOrThrow($name);

        $this->formatter = $this->formatterCollection->getFormatter($name);

    }

}