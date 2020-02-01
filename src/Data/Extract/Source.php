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

/**
 * Class DataSource
 *
 * @package Metamorphose\Data\Extract
 */
abstract class Source implements SourceInterface {

    /** Constant to override with the real type */
    const TYPE = '';

    /** @var string $name */
    protected $name;

    /**
     * DataSource constructor.
     *
     * @param string $name
     */
    public function __construct(string $name) {

        $this->name = $name;

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
     * Get a data source exception
     *
     * @param string $message
     *
     * @return MetamorphoseDataSourceException
     */
    public function getException(string $message): MetamorphoseDataSourceException {

        return new MetamorphoseDataSourceException('Data source error (' . $this->getName() . '): ' . $message);

    }

    /**
     * @inheritDoc
     */
    public static function getType(): string {

        return static::TYPE;

    }

}
