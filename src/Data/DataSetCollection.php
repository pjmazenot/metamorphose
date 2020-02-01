<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data;

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class DataSetCollection
 *
 * @package Metamorphose\Data\Extract
 */
class DataSetCollection {

    /** @var DataSet[] $dataSets */
    protected $dataSets = [];

    /**
     * Register a data set in the collection
     *
     * @param string $name
     * @param DataSet $dataSet
     */
    public function registerDataSet(string $name, DataSet $dataSet): void {

        $this->dataSets[$name] = $dataSet;

    }

    /**
     * Get a data set from the collection
     *
     * @param string $name
     *
     * @return DataSet
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataSet(string $name): DataSet {

        if(!isset($this->dataSets[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data set "' . $name . '" is not defined');

        }

        return $this->dataSets[$name];

    }

}
