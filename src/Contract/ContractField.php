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

/**
 * Class ContractField
 *
 * @package Metamorphose\Contract
 */
class ContractField {

    const TYPE_ARRAY = 'array';
    const TYPE_DECIMAL = 'decimal';
    const TYPE_JSON = 'json';
    const TYPE_NUMBER = 'number';
    const TYPE_STRING = 'string';

    /** @var string $from */
    protected $from;

    /** @var array $processors */
    protected $processors = [];

    /** @var array $validators */
    protected $validators = [];

    /** @var string $to */
    protected $to;

    public function __construct(array $fieldData) {

        $this->parseFieldData($fieldData);

    }

    /**
     * Get the field source name
     *
     * @return string
     */
    public function getFrom(): string {

        return $this->from;

    }

    /**
     * Get the list of data processors to apply
     *
     * @return array
     */
    public function getProcessors(): array {

        return $this->processors;

    }

    /**
     * Get the list of data validators to apply
     *
     * @return array
     */
    public function getValidators(): array {

        return $this->validators;

    }

    /**
     * Get the field destination name
     *
     * @return string
     */
    public function getTo(): string {

        return $this->to;

    }

    /**
     * Parse the field definition
     *
     * @param array $fieldData
     */
    protected function parseFieldData(array $fieldData): void {

        if(isset($fieldData['from'])) {

            $this->from = $fieldData['from'];

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

    }

}
