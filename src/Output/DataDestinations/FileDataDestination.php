<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Output\DataDestinations;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;
use Metamorphose\Output\DataDestination;
use Metamorphose\Output\FormatterInterface;

/**
 * Class FileDataDestination
 *
 * @package Metamorphose\Output\DataDestinations
 */
class FileDataDestination extends DataDestination {

    const NAME = 'file';

    /**
     * Load the data into a string
     *
     * @param DataSet                 $destinationData
     * @param ContractDestinationDefinition $destinationDefinition
     * @param FormatterInterface|null $formatter
     *
     * @return mixed|string
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseFormatterException
     */
    public function load(DataSet $destinationData, ContractDestinationDefinition $destinationDefinition, ?FormatterInterface $formatter) {

        if(!isset($formatter)) {

            throw new MetamorphoseDataDestinationException('The file destination need a formatter');

        } else {

            return $formatter->format($destinationData, $destinationDefinition->getOptions());

        }

    }

}
