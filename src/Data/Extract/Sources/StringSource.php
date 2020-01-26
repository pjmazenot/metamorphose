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
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseParserException;
use Metamorphose\Data\Extract\Source;
use Metamorphose\Data\Extract\ParserInterface;

/**
 * Class StringDataSource
 *
 * @package Metamorphose\Data\Extract\Sources
 */
class StringSource extends Source {

    const TYPE = 'string';

    /**
     * Extract the content from a string
     *
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Parser instance to parse the string
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract(ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): void {

        $options = $sourceDefinition->getOptions();
        $string = isset($options['string']) ? $options['string'] : null;

        if(!is_string($string)) {

            throw new MetamorphoseDataSourceException('The target content is not a string');

        } else {

            $this->data = $parser->parse($string, $sourceDefinition->getOptions());

        }

    }

}
