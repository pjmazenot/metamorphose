<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input\Parsers;

use Metamorphose\Data\DataSet;
use Metamorphose\Input\Parser;

/**
 * Class YamlParser
 *
 * @package Metamorphose\Input\Parsers
 */
class YamlParser extends Parser {

    const NAME = 'yaml';

    /**
     * Parse the data as YAML
     *
     * @param array|string $data
     *
     * @return DataSet
     */
    public function parse($data): DataSet {

        $dataArray = yaml_parse($data);

        return parent::parse($dataArray);

    }

}
