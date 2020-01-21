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

use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseException;

/**
 * Class DataSource
 *
 * @package Metamorphose\Input
 */
abstract class DataSource implements DataSourceInterface {

    /** Constant to override with the real name */
    const TYPE = '';

    /** @var DataSet $data */
    protected $data;

    /**
     * Get the raw data from a data source
     *
     * @return DataSet
     * @throws MetamorphoseException
     */
    public function getData(): DataSet {

        if(!isset($this->data)) {

            throw new MetamorphoseException('Data not extracted');

        }

        return $this->data;

    }

    // @TODO: Extract buffer

    /**
     * @inheritDoc
     */
    public static function getType(): string {

        return static::TYPE;

    }

}
