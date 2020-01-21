<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Output;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;

/**
 * Interface DataDestinationInterface
 *
 * @package Metamorphose\Output
 */
interface DataDestinationInterface {

    /**
     * Get the data
     *
     * @return DataSet
     */
    public function getData(): DataSet;

    /**
     * Load the data
     *
     * @param DataSet                 $destinationData
     * @param ContractDestinationDefinition $destinationDefinition
     * @param FormatterInterface|null $formatter
     *
     * @return mixed
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseFormatterException
     */
    public function load(DataSet $destinationData, ContractDestinationDefinition $destinationDefinition, ?FormatterInterface $formatter);

    /**
     * Get the type
     *
     * @return string
     */
    public static function getType(): string;

}
