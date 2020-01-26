<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this destination code.
 */

namespace Metamorphose\Data\Load;

use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Data\Load\Destinations\DatabaseDestination;
use Metamorphose\Data\Load\Destinations\FileDestination;
use Metamorphose\Data\Load\Destinations\StringDestination;

/**
 * Class DataDestinationCollection
 *
 * @package Metamorphose\Data\Load
 */
class DestinationCollection {

    /** @var array $destinationModels */
    protected $destinationModels = [];

    /** @var DestinationInterface[] $destinations */
    protected $destinations = [];

    /**
     * DataDestinationCollection constructor.
     *
     * @throws MetamorphoseDataDestinationException
     */
    public function __construct() {

        // Register default data destinations
        $this->registerDataDestinationModel(DatabaseDestination::class);
        $this->registerDataDestinationModel(FileDestination::class);
        $this->registerDataDestinationModel(StringDestination::class);

    }

    /**
     * Register a data destination model in the collection
     *
     * @param string $dataDestinationModel
     *
     * @throws MetamorphoseDataDestinationException
     */
    public function registerDataDestinationModel(string $dataDestinationModel): void {

        if(!is_a($dataDestinationModel, DestinationInterface::class, true)) {

            throw new MetamorphoseDataDestinationException('The data destination model does not implement the right interface');

        }

        /** @var DestinationInterface $dataDestinationModel */
        $this->destinationModels[$dataDestinationModel::getType()] = $dataDestinationModel;

    }

    /**
     * Register a data destination in the collection
     *
     * @param string               $name
     * @param DestinationInterface $dataDestination
     */
    public function registerDataDestination(string $name, DestinationInterface $dataDestination): void {

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
     * @return DestinationInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataDestination(string $name): DestinationInterface {

        if(!isset($this->destinations[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data destination "' . $name . '" is not defined');

        }

        return $this->destinations[$name];

    }

}
