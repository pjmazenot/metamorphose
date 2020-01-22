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

/**
 * Class Parser
 *
 * @package Metamorphose\Input
 */
abstract class Parser implements ParserInterface {

    /** Constant to override with the real name */
    const NAME = '';

    /**
     * @inheritDoc
     */
    public function getName(): string {

        return static::NAME;

    }

    /**
     * Parse the data
     *
     * @param array|string $data
     * @param array $options
     *
     * @return DataSet
     */
    public function parse($data, array $options = []): DataSet {

        return new DataSet($data);

    }

}
