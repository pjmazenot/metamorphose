<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input;

use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Input\DataSources\DatabaseDataSource;
use Metamorphose\Input\DataSources\FileDataSource;
use Metamorphose\Input\DataSources\StringDataSource;

/**
 * Class DataSourceCollection
 *
 * @package Metamorphose\Input
 */
class DataSourceCollection {

    /** @var array $sourceModels */
    protected $sourceModels = [];

    /** @var DataSourceInterface[] $sources */
    protected $sources = [];

    /**
     * DataSourceCollection constructor.
     *
     * @throws MetamorphoseDataSourceException
     */
    public function __construct() {

        // Register default parsers
        $this->registerDataSourceModel(DatabaseDataSource::class);
        $this->registerDataSourceModel(FileDataSource::class);
        $this->registerDataSourceModel(StringDataSource::class);

    }

    /**
     * Register a data source model in the collection
     *
     * @param string $dataSourceModel
     *
     * @throws MetamorphoseDataSourceException
     */
    public function registerDataSourceModel(string $dataSourceModel): void {

        if(!is_a($dataSourceModel, DataSourceInterface::class, true)) {

            throw new MetamorphoseDataSourceException('The data source model does not implement the right interface');

        }

        /** @var DataSourceInterface $dataSourceModel */
        $this->sourceModels[$dataSourceModel::getType()] = $dataSourceModel;

    }

    /**
     * Register a data source in the collection
     *
     * @param string $name
     * @param DataSourceInterface $dataSource
     */
    public function registerDataSource(string $name, DataSourceInterface $dataSource): void {

        $this->sources[$name] = $dataSource;

    }

    /**
     * Register a data source in the collection using an existing model
     *
     * @param string $modelType
     * @param string $sourceName
     *
     * @throws MetamorphoseDataSourceException
     */
    public function registerDataSourceFromModel(string $modelType, string $sourceName): void {

        if(empty($this->sourceModels[$modelType])) {

            throw new MetamorphoseDataSourceException('The source model ' . $modelType . ' is not defined');

        }

        $sourceModelClass = $this->sourceModels[$modelType];
        $this->sources[$sourceName] = new $sourceModelClass();

    }

    /**
     * Get a data source from the collection
     *
     * @param string $name
     *
     * @return DataSourceInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataSource(string $name): DataSourceInterface {

        if(!isset($this->sources[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data source "' . $name . '" is not defined');

        }

        return $this->sources[$name];

    }

}
