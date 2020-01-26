<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Extract;

use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Data\Extract\Sources\DatabaseSource;
use Metamorphose\Data\Extract\Sources\FileSource;
use Metamorphose\Data\Extract\Sources\StringSource;

/**
 * Class DataSourceCollection
 *
 * @package Metamorphose\Data\Extract
 */
class SourceCollection {

    /** @var array $sourceModels */
    protected $sourceModels = [];

    /** @var SourceInterface[] $sources */
    protected $sources = [];

    /**
     * DataSourceCollection constructor.
     *
     * @throws MetamorphoseDataSourceException
     */
    public function __construct() {

        // Register default data sources
        $this->registerDataSourceModel(DatabaseSource::class);
        $this->registerDataSourceModel(FileSource::class);
        $this->registerDataSourceModel(StringSource::class);

    }

    /**
     * Register a data source model in the collection
     *
     * @param string $dataSourceModel
     *
     * @throws MetamorphoseDataSourceException
     */
    public function registerDataSourceModel(string $dataSourceModel): void {

        if(!is_a($dataSourceModel, SourceInterface::class, true)) {

            throw new MetamorphoseDataSourceException('The data source model does not implement the right interface');

        }

        /** @var SourceInterface $dataSourceModel */
        $this->sourceModels[$dataSourceModel::getType()] = $dataSourceModel;

    }

    /**
     * Register a data source in the collection
     *
     * @param string          $name
     * @param SourceInterface $dataSource
     */
    public function registerDataSource(string $name, SourceInterface $dataSource): void {

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
        $this->sources[$sourceName] = new $sourceModelClass($sourceName);

    }

    /**
     * Get a data source from the collection
     *
     * @param string $name
     *
     * @return SourceInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataSource(string $name): SourceInterface {

        if(!isset($this->sources[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data source "' . $name . '" is not defined');

        }

        return $this->sources[$name];

    }

}
