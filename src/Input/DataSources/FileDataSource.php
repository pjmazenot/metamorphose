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
 * Class FileDataSource
 *
 * @package Metamorphose\Input\DataSources
 */
class FileDataSource extends DataSource {

    const TYPE = 'file';

    /**
     * Extract the content from a file
     *
     * @param array|string         $sourceData File path to extract the content from
     * @param ParserInterface|null $parser     Parser instance to parse the file content
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseParserException
     */
    public function extract($sourceData, ?ParserInterface $parser = null): void {

        $filePath = $sourceData;

        if(!isset($parser)) {

            throw new MetamorphoseDataSourceException('A parser needs to be configured for the file data source');

        } elseif(!is_string($filePath) || !file_exists($filePath)) {

            throw new MetamorphoseDataSourceException('The target file does not exist');

        } else {

            $fileContent = file_get_contents($filePath);

            $this->data = $parser->parse($fileContent);

        }

    }

}
