<?php

namespace Metamorphose\Contract;

class ContractField {

    const TYPE_ARRAY = 'array';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_JSON = 'json';
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';

    /** @var string $from */
    protected $from;

    protected $inputType;
    protected $dataProcessor;

    /** @var string $to */
    protected $to;

    protected $outputType;

    public function __construct(array $fieldData) {

        $this->parseFieldData($fieldData);

    }

    /**
     * @return mixed
     */
    public function getFrom() {

        return $this->from;

    }

    /**
     * @return mixed
     */
    public function getInputType() {

        return $this->inputType;
    }

    /**
     * @return mixed
     */
    public function getDataProcessor() {

        return $this->dataProcessor;
    }

    /**
     * @return mixed
     */
    public function getTo() {

        return $this->to;

    }

    /**
     * @return mixed
     */
    public function getOutputType() {

        return $this->outputType;

    }

    protected function parseFieldData(array $fieldData): void {

        if(isset($fieldData['from'])) {
            $this->from = $fieldData['from'];
        }

        if(isset($fieldData['input_type'])) {
            $this->inputType = $fieldData['input_type'];
        }

        if(isset($fieldData['data_processor'])) {
            $this->dataProcessor = $fieldData['data_processor'];
        }

        if(isset($fieldData['to'])) {
            $this->to = $fieldData['to'];
        }

        if(isset($fieldData['output_type'])) {
            $this->outputType = $fieldData['output_type'];
        }

    }

}
