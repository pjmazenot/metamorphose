<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;

/**
 * Interface DataDestinationInterface
 *
 * @package Metamorphose\Data\Load
 */
interface DestinationInterface {

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Load the data
     *
     * @param DataSet                       $finalDataSet
     * @param ContractDestinationDefinition $destinationDefinition
     * @param FormatterInterface|null       $formatter
     *
     * @return mixed
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseFormatterException
     */
    public function load(DataSet $finalDataSet, ContractDestinationDefinition $destinationDefinition, ?FormatterInterface $formatter);

    /**
     * Get the type
     *
     * @return string
     */
    public static function getType(): string;

}
