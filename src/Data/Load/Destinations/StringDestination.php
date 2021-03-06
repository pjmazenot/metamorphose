<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load\Destinations;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;
use Metamorphose\Data\Load\Destination;
use Metamorphose\Data\Load\FormatterInterface;

/**
 * Class StringDestination
 *
 * @package Metamorphose\Data\Load\Destinations
 */
class StringDestination extends Destination {

    const TYPE = 'string';

    /**
     * Load the data into a string
     *
     * @param DataSet                       $finalDataSet
     * @param ContractDestinationDefinition $destinationDefinition
     * @param FormatterInterface|null       $formatter
     *
     * @return mixed|string
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseFormatterException
     */
    public function load(DataSet $finalDataSet, ContractDestinationDefinition $destinationDefinition, ?FormatterInterface $formatter) {

        if(!isset($formatter)) {

            throw new MetamorphoseDataDestinationException('The string destination need a formatter');

        } else {

            return $formatter->format($finalDataSet, $destinationDefinition->getOptions());

        }

    }

}
