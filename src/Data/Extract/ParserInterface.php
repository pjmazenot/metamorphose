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

use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseParserException;

/**
 * Interface ParserInterface
 *
 * @package Metamorphose\Data\Extract
 */
interface ParserInterface {

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Parse the data
     *
     * @param array|string $data
     * @param array $options
     *
     * @return DataSet
     * @throws MetamorphoseParserException
     */
    public function parse($data, array $options = []): DataSet;

}
