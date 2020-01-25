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
 * Class ContractSourceDefinition
 *
 * @TODO: Support joins between two collections with <> number of rows (ex: ci) / define a dataset to process (order)?
 *
 * @package Metamorphose\Contract\Definitions
 */
class ContractSourceDefinition {

    const STRUCTURE_COLLECTION = 'collection';
    const STRUCTURE_OBJECT = 'object';

    /** @var string $name */
    protected $name;

    /** @var string $type */
    protected $type;

    /** @var string|null $parser */
    protected $parser;

    /** @var string $structure */
    protected $structure;

    /** @var array $options */
    protected $options = [];

    /** @var ContractFieldDefinition[] $fields */
    protected $fields = [];

    /**
     * ContractSource constructor.
     *
     * @param array $sourceData
     */
    public function __construct(array $sourceData) {

        $this->parseSourceData($sourceData);

    }

    /**
     * Get the source name
     *
     * @return string
     */
    public function getName(): string {

        return $this->name;

    }

    /**
     * Get the source type
     *
     * @return string
     */
    public function getType(): string {

        return $this->type;

    }

    /**
     * Get the source parser
     *
     * @return string|null
     */
    public function getParser(): ?string {

        return $this->parser;

    }

    /**
     * Get the source structure
     *
     * @return string
     */
    public function getStructure(): string {

        return $this->structure;

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
     * Parse the source definition
     *
     * @param array $sourceData
     */
    protected function parseSourceData(array $sourceData): void {

        if(isset($sourceData['name'])) {

            $this->name = $sourceData['name'];

        }

        if(isset($sourceData['type'])) {

            $this->type = $sourceData['type'];

        }

        if(isset($sourceData['parser'])) {

            $this->parser = $sourceData['parser'];

        }

        if(isset($sourceData['structure'])) {

            $this->structure = $sourceData['structure'];

        }

        if(!empty($sourceData['options'])) {

            $this->options = $sourceData['options'];

        }

        if(!empty($sourceData['fields'])) {

            foreach($sourceData['fields'] as $fieldData) {

                $this->fields[] = new ContractFieldDefinition($fieldData);

            }

        }

    }

}
