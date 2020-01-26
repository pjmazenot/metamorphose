<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load;

use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;

/**
 * Class DataDestination
 *
 * @package Metamorphose\Data\Load
 */
abstract class Destination implements DestinationInterface {

    /** Constant to override with the real type */
    const TYPE = '';

    /** @var string $name */
    protected $name;

    /** @var DataSet $data */
    protected $data;

    /**
     * DataDestination constructor.
     *
     * @param string $name
     */
    public function __construct(string $name) {

        $this->name = $name;
        $this->data = new DataSet();

    }

    /**
     * Get the data source name
     *
     * @return string
     */
    public function getName(): string {

        return $this->name;

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
     * Get a data destination exception
     *
     * @param string $message
     *
     * @return MetamorphoseDataDestinationException
     */
    public function getException(string $message): MetamorphoseDataDestinationException {

        return new MetamorphoseDataDestinationException('Data destination error (' . $this->getName() . '): ' . $message);

    }

    /**
     * @inheritDoc
     */
    public static function getType(): string {

        return static::TYPE;

    }

}
