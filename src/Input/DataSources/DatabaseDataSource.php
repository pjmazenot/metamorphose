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

    /**
     * Extract the content from a string
     *
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Optional parser name
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract(ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): void {

        $options = $sourceDefinition->getOptions();
        
        if(empty($options['connection']['dsn'])) {

            throw $this->getException('No connection info provided');

        }

        if(empty($options['query'])) {

            throw $this->getException('No query provided');

        }

        if(empty($options['params'])) {

            $options['params'] = [];

        }

        // Init the connection
        $connection = new \PDO(
            $options['connection']['dsn'],
            isset($options['connection']['username']) ? $options['connection']['username'] : null,
            isset($options['connection']['password']) ? $options['connection']['password'] : null,
            isset($options['connection']['options']) ? $options['connection']['options'] : null
        );

        // Prepare the query
        $prep = $connection->prepare($options['query']);

        // Execute the query
        $isExecuted = $prep->execute($options['params']);

        if($isExecuted === false) {

            throw $this->getException('The query couldn\'t be executed, reason: "' . $prep->errorInfo()[2] . '" (' . $options['query'] . ' - array(' . implode(', ', $valueArray) . '))');

        }

        $results = $prep->fetchAll(\PDO::FETCH_ASSOC);

        if(empty($results)) {

            throw $this->getException('No result for the query');

        }

        if($sourceDefinition->getType() === ContractSourceDefinition::STRUCTURE_OBJECT) {

            // @TODO: Should we send a warning when there is more than one result?
            $this->data = $parser->parse($results[0], $sourceDefinition->getOptions());

        } else {

            $this->data = $parser->parse($results[0], $sourceDefinition->getOptions());

        }

    }

}
