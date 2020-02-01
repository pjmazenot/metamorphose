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
 * Class FileDataSource
 *
 * @package Metamorphose\Data\Extract\Sources
 */
class FileSource extends Source {

    const TYPE = 'file';

    /**
     * Extract the content from a file
     *
     * @param ContractSourceDefinition $sourceDefinition
     * @param ParserInterface|null $parser     Parser instance to parse the file content
     *
     * @return DataSet
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract(ContractSourceDefinition $sourceDefinition, ?ParserInterface $parser = null): DataSet {

        $options = $sourceDefinition->getOptions();
        $filePath = isset($options['file']) ? $options['file'] : null;

        if(!isset($parser)) {

            throw new MetamorphoseDataSourceException('A parser needs to be configured for the file data source');

        } elseif(!is_string($filePath) || !file_exists($filePath)) {

            throw new MetamorphoseDataSourceException('The target file does not exist');

        } else {

            $fileContent = file_get_contents($filePath);

            return $parser->parse($fileContent, $sourceDefinition->getOptions());

        }

    }

}
