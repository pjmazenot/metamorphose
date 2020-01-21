<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input\DataSources;

use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseParserException;
use Metamorphose\Input\DataSource;
use Metamorphose\Input\ParserInterface;

/**
 * Class DatabaseDataSource
 *
 * @package Metamorphose\Input\DataSources
 */
class DatabaseDataSource extends DataSource {

    const TYPE = 'database';

    /**
     * Extract the content from a string
     *
     * @param array|string         $sourceData TBD
     * @param ParserInterface|null $parser     Optional parser name
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract($sourceData, ?ParserInterface $parser = null): void {

        // @TODO: Handle PDO queries

    }

}
