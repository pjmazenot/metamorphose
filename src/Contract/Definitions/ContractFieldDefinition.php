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

    /** @var ContractAttributeDefinition[] $apply */
    protected $attributes = [];

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
     * @return ContractApplyDefinition[]
     */
    public function getApply(): array {

        return $this->apply;

    }

    /**
     * Get the list of attributes
     *
     * @return ContractAttributeDefinition[]
     */
    public function getAttributes(): array {

        return $this->attributes;

    }

    /**
     * Parse the field definition
     *
     * @param array $fieldData
     */
    protected function parseFieldData(array $fieldData): void {

        if (isset($fieldData['name'])) {

            $this->name = $fieldData['name'];

        }

        if (!empty($fieldData['apply'])) {

            foreach ($fieldData['apply'] as $apply) {

                $this->apply[] = new ContractApplyDefinition($apply);

            }

        }

        if (!empty($fieldData['attributes'])) {

            foreach ($fieldData['attributes'] as $attribute) {

                $this->attributes[] = new ContractAttributeDefinition($attribute);

            }

        }

    }

}
