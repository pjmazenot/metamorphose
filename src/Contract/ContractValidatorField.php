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
 * Class ContractValidatorField
 *
 * @package Metamorphose\Contract
 */
class ContractValidatorField {

    /** @var bool $mandatory */
    protected $mandatory;

    /** @var string $to */
    protected $to;

    /**
     * ContractValidatorField constructor.
     *
     * @param array $fieldData
     */
    public function __construct(array $fieldData) {

        $this->parseFieldData($fieldData);

    }

    /**
     * Get the mandatory flag
     *
     * @return bool
     */
    public function isMandatory(): bool {

        return $this->mandatory;

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

        if(isset($fieldData['mandatory'])) {

            $this->mandatory = $fieldData['mandatory'];

        }

        if(isset($fieldData['to'])) {

            $this->to = $fieldData['to'];

        }

    }

}
