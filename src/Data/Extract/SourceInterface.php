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

use Metamorphose\Contract\Definitions\ContractSourceDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseParserException;

/**
 * Interface DataSourceInterface
 *
 * @package Metamorphose\Data\Extract
 */
interface SourceInterface {

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Extract the data from the data source
     *
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser
     *
     * @return DataSet
     * @throws MetamorphoseParserException
     * @throws MetamorphoseDataSourceException
     */
    public function extract(ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser): DataSet;

    /**
     * Get the type
     *
     * @return string
     */
    public static function getType(): string;

}
