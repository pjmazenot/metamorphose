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
 * Class StringDataSource
 *
 * @package Metamorphose\Input\DataSources
 */
class StringDataSource extends DataSource {

    const TYPE = 'string';

    /**
     * Extract the content from a string
     *
     * @param array|string         $sourceData String to extract the content from
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Parser instance to parse the string
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract($sourceData, ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): void {

        $string = $sourceData;

        if(!is_string($string)) {

            throw new MetamorphoseDataSourceException('The target content is not a string');

        } else {

            $this->data = $parser->parse($string, $sourceDefinition->getOptions());

        }

    }

}
