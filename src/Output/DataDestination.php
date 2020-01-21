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

use Metamorphose\Data\DataSet;

/**
 * Class DataDestination
 *
 * @package Metamorphose\Output
 */
abstract class DataDestination implements DataDestinationInterface {

    /** Constant to override with the real name */
    const NAME = '';

    /** @var DataSet $data */
    protected $data;

    /**
     * DataDestination constructor.
     */
    public function __construct() {

        $this->data = new DataSet();

    }

    /**
     * Get the raw data from a data source
     *
     * @return DataSet
     */
    public function getData(): DataSet {

        return $this->data;

    }

    // @TODO: Load buffer

    /**
     * @inheritDoc
     */
    public static function getType(): string {

        return static::NAME;

    }

}
