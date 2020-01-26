<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Contract\Definitions;

/**
 * Class ContractFieldApplyDefinition
 *
 * @package Metamorphose\Contract\Definitions
 */
class ContractApplyDefinition {

    const TYPE_VALUE = 'value';
    const TYPE_PROCESSOR = 'processor';
    const TYPE_VALIDATOR = 'validator';

    /** @var string $type */
    protected $type;

    /** @var string $name */
    protected $name;

    /** @var string $value */
    protected $value;

    /** @var array $args */
    protected $args = [];

    /**
     * ContractFieldDefinition constructor.
     *
     * @param array $applyData
     */
    public function __construct(array $applyData) {

        $this->parseApplyData($applyData);

    }

    /**
     * Get the apply name
     *
     * @return string
     */
    public function getType(): string {

        return $this->type;

    }

    /**
     * Get the apply name
     *
     * @return string
     */
    public function getName(): string {

        return $this->name;

    }

    /**
     * Get the value
     *
     * @return mixed
     */
    public function getValue() {

        return $this->value;

    }

    /**
     * Get the list of instructions to apply
     *
     * @return array
     */
    public function getArgs(): array {

        return $this->args;

    }

    /**
     * Parse the apply definition
     *
     * @param array $applyData
     */
    protected function parseApplyData(array $applyData): void {

        if (isset($applyData['type'])) {

            $this->type = $applyData['type'];

        }

        if (isset($applyData['name'])) {

            $this->name = $applyData['name'];

        }

        if (isset($applyData['value'])) {

            $this->value = $applyData['value'];

        }

        if (isset($applyData['args'])) {

            $this->args = $applyData['args'];

        }

    }

}
