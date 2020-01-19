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
 * Interface ContractInterface
 *
 * @package Metamorphose\Contract
 */
interface ContractInterface {

    /**
     * Get the contract formatters
     *
     * @return array
     */
    public function getFormatters(): array;

    /**
     * Get the contract fields
     *
     * @return ContractField[]
     */
    public function getFields(): array;

}
