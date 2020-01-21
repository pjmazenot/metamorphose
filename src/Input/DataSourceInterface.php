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
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseParserException;

/**
 * Interface DataSourceInterface
 *
 * @package Metamorphose\Input
 */
interface DataSourceInterface {

    /**
     * Get the data
     *
     * @return DataSet
     */
    public function getData(): DataSet;

    /**
     * Extract the data from the data source
     *
     * @param array                $sourceData
     * @param ParserInterface|null $parser
     *
     * @throws MetamorphoseParserException
     * @throws MetamorphoseDataSourceException
     */
    public function extract(array $sourceData, ?ParserInterface $parser): void;

    /**
     * Get the type
     *
     * @return string
     */
    public static function getType(): string;

}
