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
 * Class ContractFieldDefinition
 *
 * @package Metamorphose\Contract\Definitions
 */
class ContractFieldDefinition {

    /** @var string $name */
    protected $name;

    /** @var array $apply */
    protected $apply = [];

    /**
     * ContractFieldDefinition constructor.
     *
     * @param array $fieldData
     */
    public function __construct(array $fieldData) {

        $this->parseFieldData($fieldData);

    }

    /**
     * Get the field name
     *
     * @return string
     */
    public function getName(): string {

        return $this->name;

    }

    /**
     * Get the list of instructions to apply
     *
     * @return array
     */
    public function getApply(): array {

        return $this->apply;

    }

    /**
     * Parse the field definition
     *
     * @param array $fieldData
     */
    protected function parseFieldData(array $fieldData): void {

        if(isset($fieldData['name'])) {

            $this->name = $fieldData['name'];

        }

        if(isset($fieldData['apply'])) {

            $this->apply = $fieldData['apply'];

        }

    }

}
