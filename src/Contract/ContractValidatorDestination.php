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

use Metamorphose\Exceptions\MetamorphoseContractException;

/**
 * Class ContractValidatorDestination
 *
 * @package Metamorphose\Contract
 */
class ContractValidatorDestination {

    /** @var string $type */
    protected $type;

    /** @var array $formats */
    protected $formats = [];

    /** @var string $structure */
    protected $structure;

    /** @var ContractValidatorField[] $fields */
    protected $fields = [];

    /**
     * Get the type
     *
     * @return string
     */
    public function getType(): string {

        return $this->type;

    }

    /**
     * Get the formats
     *
     * @return array
     */
    public function getFormats(): array {

        return $this->formats;

    }

    /**
     * Get the structure
     *
     * @return string
     */
    public function getStructure(): string {

        return $this->structure;

    }

    /**
     * Get the fields
     *
     * @return ContractValidatorField[]
     */
    public function getFields(): array {

        return $this->fields;

    }

    /**
     * ContractValidatorDestination constructor.
     *
     * @param array $destinationData
     *
     * @throws MetamorphoseContractException
     */
    public function __construct(array $destinationData) {

        if(isset($destinationData['type'])) {

            $this->type = $destinationData['type'];

        }

        if(isset($destinationData['formats'])) {

            $this->formats = $destinationData['formats'];

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one output formats');

        }

        if(isset($destinationData['structure'])) {

            $this->structure = $destinationData['structure'];

        }

        if(isset($destinationData['fields'])) {

            foreach($destinationData['fields'] as $fieldData) {

                $this->fields[] = new ContractValidatorField($fieldData);

            }

        }

    }

}
