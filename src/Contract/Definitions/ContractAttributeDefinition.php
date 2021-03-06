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
 * Class ContractAttributeDefinition
 *
 * @package Metamorphose\Contract\Definitions
 */
class ContractAttributeDefinition {

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
     * @return ContractApplyDefinition[]
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

        if (isset($fieldData['name'])) {

            $this->name = $fieldData['name'];

        }

        if (!empty($fieldData['apply'])) {

            foreach ($fieldData['apply'] as $apply) {

                $this->apply[] = new ContractApplyDefinition($apply);

            }

        }

    }

}
