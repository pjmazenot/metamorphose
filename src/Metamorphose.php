<?php

namespace Metamorphose;

use Metamorphose\Contract\Contract;
use Metamorphose\Contract\ContractValidator;
use Metamorphose\Data\DataProcessorCollection;
use Metamorphose\Data\DataProcessorInterface;
use Metamorphose\Data\DataSet;
use Metamorphose\Input\ParserCollection;
use Metamorphose\Input\ParserInterface;
use Metamorphose\Output\FormatterCollection;
use Metamorphose\Output\FormatterInterface;

class Metamorphose {

    const SOURCE_TYPE_ARRAY = 'array';
    const SOURCE_TYPE_FILE = 'file';
    const SOURCE_TYPE_STRING = 'string';

    /** @var Contract $contract */
    protected $contract;

    /** @var ContractValidator $contractValidator */
    protected $contractValidator;

    /** @var ParserCollection $parserCollection */
    protected $parserCollection;

    /** @var DataProcessorCollection $dataProcessorCollection */
    protected $dataProcessorCollection;

    /** @var FormatterCollection $outputFormatter */
    protected $formatterCollection;

    /** @var string $sourceType */
    protected $sourceType;

    /** @var string|array $source */
    protected $source;

    /** @var ParserInterface $parser */
    protected $parser;

    /** @var FormatterInterface $parser */
    protected $formatter;

    public function __construct(string $inputContractFilePath, string $outputContractFilePath = null) {

        $this->parserCollection = new ParserCollection();
        $this->dataProcessorCollection = new DataProcessorCollection();
        $this->formatterCollection = new FormatterCollection();

        $this->contract = new Contract($inputContractFilePath);

        if(isset($outputContractFilePath)) {
            $this->contractValidator = new ContractValidator($outputContractFilePath);
        }

    }

    public function registerParser(string $name, ParserInterface $parser): void {

        $this->parserCollection->registerParser($name, $parser);

    }

    public function registerDataProcessor(string $name, DataProcessorInterface $dataProcessor): void {

        $this->dataProcessorCollection->registerDataProcessor($name, $dataProcessor);

    }

    public function registerFormatter(string $name, FormatterInterface $formatter): void {

        $this->formatterCollection->registerFormatter($name, $formatter);

    }

    public function load(string $sourceType, string $source, string $parserName = null) {

        $this->sourceType = $sourceType;
        $this->source = $source;

        if (!isset($parserName)) {
            $parserName = $this->contract->getDefaultParserName();
        } else {
            $this->contract->isParserAuthorizedOrThrow($parserName);
        }

        $this->parser = $this->parserCollection->getParser($parserName);

    }

    // @TODO: Buffer (nbItem) - for CSV for example or JSON/XML collections

    public function convert(string $formatterName = null) {

        if (!isset($formatterName)) {
            $formatterName = $this->contract->getDefaultFormatterName();
        } else {
            $this->contract->isFormatterAuthorizedOrThrow($formatterName);
        }

        $this->formatter = $this->formatterCollection->getFormatter($formatterName);

        switch ($this->sourceType) {
            case self::SOURCE_TYPE_ARRAY:
                $this->parser->parseArray($this->source);
                break;
            case self::SOURCE_TYPE_FILE:
                $this->parser->parseFile($this->source);
                break;
            case self::SOURCE_TYPE_STRING:
            default:
                $this->parser->parseString($this->source);
                break;
        }

        $convertedData = $this->applyContract();

        return $this->formatter->format($convertedData, $this->contract->getOptions());

    }


    public function applyContract() {

        if($this->contract->getType() === Contract::TYPE_COLLECTION) {

            $convertedItems = [];
            $count = $this->parser->getParsedData()->getCount();

            for($i = 0; $i < $count; $i++) {

                $convertedItems[] = $this->processObject($i);

            }

            $convertedData = new DataSet($convertedItems);

        } else {

            $convertedData = new DataSet($this->processObject());

        }

        return $convertedData->getData()->toArray();

    }

    public function processObject(?int $key = null) {

        $dataHolder = new DataSet();

        // We may need a prefix to get the right object when we process collections (when $key is set)
        $prefix = isset($key) ? $key . '.' : '';

        foreach($this->contract->getFields() as $field) {

            // Grab the content from the source data
            $value = $this->parser->getParsedData()->get($prefix . $field->getInputKey());

            // @TODO: Data processor
            // @TODO: Data validator

            $dataHolder->set($field->getOutputKey(), $value);

        }

        return $dataHolder->getData()->toArray();

    }

}