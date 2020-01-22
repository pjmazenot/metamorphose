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

use Metamorphose\Contract\Definitions\ContractSourceDefinition;
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

    /** @var \PDO $connection */
    protected $connection;

    /**
     * DatabaseDataSource constructor.
     *
     * @param string $dsn
     * @param string $user
     * @param string $password
     * @param array  $options
     */
    public function __construct(string $dsn, string $user, string $password, array $options = []) {

        // Init the connection
        $this->connection = new \PDO($dsn, $user, $password, $options);

    }

    /**
     * Extract the content from a string
     *
     * @param array|string         $sourceData TBD
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Optional parser name
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract($sourceData, ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): void {

        // Get PDO connection string

        // @TODO: Handle PDO queries

    }

}
