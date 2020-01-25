<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this destination code.
 */

namespace Metamorphose\Output;

use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Output\DataDestinations\DatabaseDataDestination;
use Metamorphose\Output\DataDestinations\FileDataDestination;
use Metamorphose\Output\DataDestinations\StringDataDestination;

/**
 * Class DataDestinationCollection
 *
 * @package Metamorphose\Output
 */
class DataDestinationCollection {

    /** @var array $destinationModels */
    protected $destinationModels = [];

    /** @var DataDestinationInterface[] $destinations */
    protected $destinations = [];

    /**
     * DataDestinationCollection constructor.
     *
     * @throws MetamorphoseDataDestinationException
     */
    public function __construct() {

        // Register default parsers
        $this->registerDataDestinationModel(DatabaseDataDestination::class);
        $this->registerDataDestinationModel(FileDataDestination::class);
        $this->registerDataDestinationModel(StringDataDestination::class);

    }

    /**
     * Register a data destination model in the collection
     *
     * @param string $dataDestinationModel
     *
     * @throws MetamorphoseDataDestinationException
     */
    public function registerDataDestinationModel(string $dataDestinationModel): void {

        if(!is_a($dataDestinationModel, DataDestinationInterface::class, true)) {

            throw new MetamorphoseDataDestinationException('The data destination model does not implement the right interface');

        }

        /** @var DataDestinationInterface $dataDestinationModel */
        $this->destinationModels[$dataDestinationModel::getType()] = $dataDestinationModel;

    }

    /**
     * Register a data destination in the collection
     *
     * @param string $name
     * @param DataDestinationInterface $dataDestination
     */
    public function registerDataDestination(string $name, DataDestinationInterface $dataDestination): void {

        $this->destinations[$name] = $dataDestination;

    }

    /**
     * Register a data destination in the collection using an existing model
     *
     * @param string $modelType
     * @param string $destinationName
     *
     * @throws MetamorphoseDataDestinationException
     */
    public function registerDataDestinationFromModel(string $modelType, string $destinationName): void {

        if(empty($this->destinationModels[$modelType])) {

            throw new MetamorphoseDataDestinationException('The destination model ' . $modelType . ' is not defined');

        }

        $destinationModelClass = $this->destinationModels[$modelType];
        $this->destinations[$destinationName] = new $destinationModelClass($destinationName);

    }

    /**
     * Get a data destination from the collection
     *
     * @param string $name
     *
     * @return DataDestinationInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataDestination(string $name): DataDestinationInterface {

        if(!isset($this->destinations[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data destination "' . $name . '" is not defined');

        }

        return $this->destinations[$name];

    }

}
