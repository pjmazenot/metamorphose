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
 * Interface ParserInterface
 *
 * @package Metamorphose\Input
 */
interface ParserInterface {

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the parsed data
     *
     * @return DataSet
     */
    public function getParsedData(): DataSet;

    /**
     * Parse the data from an array
     *
     * @param array $array
     */
    public function parseArray(array $array): void;

    /**
     * Parse the data from a file
     *
     * @param string $filePath
     */
    public function parseFile(string $filePath): void;

    /**
     * Parse the data from a string
     *
     * @param string $string
     */
    public function parseString(string $string): void;

}
