<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load\Destinations;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Data\Load\Destination;
use Metamorphose\Data\Load\FormatterInterface;

/**
 * Class DatabaseDestination
 *
 * @package Metamorphose\Data\Load\Destinations
 */
class DatabaseDestination extends Destination {

    const TYPE = 'database';

    /**
     * Load the data into a string
     *
     * @param DataSet                       $finalDataSet
     * @param ContractDestinationDefinition $destinationDefinition
     * @param FormatterInterface|null       $formatter
     *
     * @return mixed
     * @throws MetamorphoseDataDestinationException
     */
    public function load(DataSet $finalDataSet, ContractDestinationDefinition $destinationDefinition, ?FormatterInterface $formatter) {

        $dataArray = $finalDataSet->getData()->toArray();
        $options = $destinationDefinition->getOptions();

        if(empty($options['connection']['dsn'])) {

            throw $this->getException('No connection info provided');

        }

        if(empty($options['table_name'])) {

            throw $this->getException('No table name provided');

        }

        // Init the connection
        $connection = new \PDO(
            $options['connection']['dsn'],
            isset($options['connection']['username']) ? $options['connection']['username'] : null,
            isset($options['connection']['password']) ? $options['connection']['password'] : null,
            isset($options['connection']['options']) ? $options['connection']['options'] : null
        );

        $fieldNames = [];
        foreach($destinationDefinition->getFields() as $field) {

            $fieldNames[] = $field->getName();

        }

        $query = 'INSERT INTO ' . $options['table_name'] . ' (' . implode(', ', $fieldNames) . ') VALUES ';
        $valuesTemplate = '(' . implode(', ', array_fill(0, count($fieldNames), '?')) . ')';

        if($destinationDefinition->getType() === ContractDestinationDefinition::STRUCTURE_OBJECT) {

            $values = $valuesTemplate;
            $params = $dataArray;

        } else {

            $values = [];
            $params = [];
            foreach($dataArray as $dataItem) {

                $values[] = $valuesTemplate;
                $params = array_merge($params, array_values($dataItem));

            }

            $values = implode(', ', $values);

        }

        // Prepare the query
        $prep = $connection->prepare($query . $values);

        // Execute the query
        $isExecuted = $prep->execute($params);

        if($isExecuted === false) {

            throw $this->getException('The query couldn\'t be executed, reason: "' . $prep->errorInfo()[2] . '" (' . $query . $values . ' - array(' . implode(', ', $params) . '))');

        }

        return $isExecuted;

    }

}
