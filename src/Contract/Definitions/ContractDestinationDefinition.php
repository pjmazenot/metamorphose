<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this destination code.
 */

namespace Metamorphose\Contract\Definitions;

/**
 * Class ContractDestinationDefinition
 *
 * @package Metamorphose\Contract\Definitions
 */
class ContractDestinationDefinition {

    const STRUCTURE_COLLECTION = 'collection';
    const STRUCTURE_OBJECT = 'object';

    /** @var string $name */
    protected $name;

    /** @var string $type */
    protected $type;

    /** @var string|null $formatter */
    protected $formatter;

    /** @var array $options */
    protected $options = [];

    /** @var ContractFieldDefinition[] $fields */
    protected $fields = [];

    /**
     * ContractSource constructor.
     *
     * @param array $destinationData
     */
    public function __construct(array $destinationData) {

        $this->parseSourceData($destinationData);

    }

    /**
     * Get the destination name
     *
     * @return string
     */
    public function getName(): string {

        return $this->name;

    }

    /**
     * Get the destination type
     *
     * @return string
     */
    public function getType(): string {

        return $this->type;

    }

    /**
     * Get the destination formatter
     *
     * @return string|null
     */
    public function getFormatter(): ?string {

        return $this->formatter;

    }

    /**
     * Get the options to apply
     *
     * @return array
     */
    public function getOptions(): array {

        return $this->options;

    }

    /**
     * Set dynamic options (override any static value for a corresponding key)
     *
     * @param array $dynamicOptions
     */
    public function setDynamicOptions(array $dynamicOptions): void {

        $this->options = array_merge($this->options, $dynamicOptions);

    }

    /**
     * Get the fields
     *
     * @return ContractFieldDefinition[]
     */
    public function getFields(): array {

        return $this->fields;

    }

    /**
     * Parse the destination definition
     *
     * @param array $destinationData
     */
    protected function parseSourceData(array $destinationData): void {

        if(isset($destinationData['name'])) {

            $this->name = $destinationData['name'];

        }

        if(isset($destinationData['type'])) {

            $this->type = $destinationData['type'];

        }

        if(isset($destinationData['formatter'])) {

            $this->formatter = $destinationData['formatter'];

        }

        if(isset($destinationData['options'])) {

            $this->options = $destinationData['options'];

        }

        if(isset($destinationData['fields'])) {

            foreach($destinationData['fields'] as $fieldData) {

                $this->fields[] = new ContractFieldDefinition($fieldData);

            }

        }

    }

}
