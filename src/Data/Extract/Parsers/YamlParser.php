<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Extract\Parsers;

use Metamorphose\Data\DataSet;
use Metamorphose\Data\Extract\Parser;

/**
 * Class YamlParser
 *
 * @package Metamorphose\Data\Extract\Parsers
 */
class YamlParser extends Parser {

    const NAME = 'yaml';

    /**
     * Parse the data as YAML
     *
     * @param array|string $data
     * @param array $options
     *
     * @return DataSet
     */
    public function parse($data, array $options = []): DataSet {

        $dataArray = yaml_parse($data);

        return parent::parse($dataArray);

    }

}
