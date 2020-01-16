<?php

namespace Metamorphose;

use Metamorphose\Contract\Contract;
use Metamorphose\Contract\ContractValidator;
use Metamorphose\Data\DataProcessorCollection;
use Metamorphose\Data\DataProcessorInterface;
use Metamorphose\Data\DataSet;
use Metamorphose\Data\DataValidatorCollection;
use Metamorphose\Data\DataValidatorInterface;
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

    /** @var DataValidatorCollection $dataValidatorCollection */
    protected $dataValidatorCollection;

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
        $this->dataValidatorCollection = new DataValidatorCollection();
        $this->formatterCollection = new FormatterCollection();

        $this->contract = new Contract($inputContractFilePath);

        if(isset($outputContractFilePath)) {

            $this->contractValidator = new ContractValidator($outputContractFilePath);

        }

        // Load the default parser if none have been specified yet
        if (!isset($this->parser)) {

            $parserName = $this->contract->getDefaultParserName();

            $this->parser = $this->parserCollection->getParser($parserName);

        }

        // Load the default formatter if none have been specified yet
        if (!isset($this->formatter)) {

            $formatterName = $this->contract->getDefaultFormatterName();

            $this->formatter = $this->formatterCollection->getFormatter($formatterName);

        }

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

    public function load(string $sourceType, string $source) {

        $this->sourceType = $sourceType;
        $this->source = $source;

    }

    public function useParser(string $parserName) {

        $this->contract->isParserAuthorizedOrThrow($parserName);

        $this->parser = $this->parserCollection->getParser($parserName);

    }

    public function useFormatter(string $formatterName) {

        $this->contract->isFormatterAuthorizedOrThrow($formatterName);

        $this->formatter = $this->formatterCollection->getFormatter($formatterName);

    }

    // @TODO: Buffer (nbItem) - for CSV for example or JSON/XML collections

    public function convert() {

        // Create the data set from the input data
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

        // @TODO: Validate automatically from options?

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

    protected function processObject(?int $key = null) {

        $dataHolder = new DataSet();

        // We may need a prefix to get the right object when we process collections (when $key is set)
        $prefix = isset($key) ? $key . '.' : '';

        foreach($this->contract->getFields() as $field) {

            // Grab the content from the source data
            $value = $this->parser->getParsedData()->get($prefix . $field->getFrom());

            // Process the value
            $processedValue = $value;
            foreach($field->getProcessors() as $processorName) {

                $processor = $this->dataProcessorCollection->getDataProcessor($processorName);

                $processedValue = $processor->process($value);

            }

            // Validate the value
            foreach($field->getValidators() as $validatorName) {

                $validator = $this->dataValidatorCollection->getDataValidator($validatorName);

                $isValid = $validator->validate($value);

                if(!$isValid) {
                    throw new \Exception('Invalid value for the target field ' . $field->getTo());
                }

            }

            // Set the final value
            $dataHolder->set($field->getTo(), $processedValue);

        }

        return $dataHolder->getData()->toArray();

    }

}