<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Extract\Sources;

use Metamorphose\Contract\Definitions\ContractSourceDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseParserException;
use Metamorphose\Data\Extract\Source;
use Metamorphose\Data\Extract\ParserInterface;

/**
 * Class DatabaseDataSource
 *
 * @package Metamorphose\Data\Extract\Sources
 */
class DatabaseSource extends Source {

    const TYPE = 'database';

    /**
     * Extract the content from a string
     *
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Optional parser name
     *
     * @return DataSet
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract(ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): DataSet {

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

            throw $this->getException('The query couldn\'t be executed, reason: "' . $prep->errorInfo()[2] . '" (' . $options['query'] . ' - array(' . implode(', ', $options['params']) . '))');

        }

        $results = $prep->fetchAll(\PDO::FETCH_ASSOC);

        if(empty($results)) {

            throw $this->getException('No result for the query');

        }

        if($sourceDefinition->getType() === ContractSourceDefinition::STRUCTURE_OBJECT) {

            if(count($results) > 1) {

                throw new MetamorphoseDataSourceException('The query returned more than on result. Please add a LIMIT clause or change the structure to "collection"');

            }

            return $parser->parse($results[0], $sourceDefinition->getOptions());

        } else {

            return $parser->parse($results[0], $sourceDefinition->getOptions());

        }

    }

}
