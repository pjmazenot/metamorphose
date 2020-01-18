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

class ContractField {

    const TYPE_ARRAY = 'array';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_JSON = 'json';
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';

    /** @var string $from */
    protected $from;

    protected $inputType;

    /** @var array $processors */
    protected $processors = [];

    /** @var array $validators */
    protected $validators = [];

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
     * @return array
     */
    public function getProcessors(): array {

        return $this->processors;

    }

    /**
     * @return array
     */
    public function getValidators(): array {

        return $this->validators;

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

        if(isset($fieldData['processors'])) {
            $this->processors = $fieldData['processors'];
        }

        if(isset($fieldData['validators'])) {
            $this->validators = $fieldData['validators'];
        }

        if(isset($fieldData['to'])) {
            $this->to = $fieldData['to'];
        }

        if(isset($fieldData['output_type'])) {
            $this->outputType = $fieldData['output_type'];
        }

    }

}
