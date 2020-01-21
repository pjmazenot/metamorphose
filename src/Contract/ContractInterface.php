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

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Contract\Definitions\ContractSourceDefinition;

/**
 * Interface ContractInterface
 *
 * @package Metamorphose\Contract
 */
interface ContractInterface {

    /**
     * Get the contract sources
     *
     * @return ContractSourceDefinition[]
     */
    public function getSources(): array;

    /**
     * Get the contract destinations
     *
     * @return ContractDestinationDefinition[]
     */
    public function getDestinations(): array;

}
