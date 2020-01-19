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

use Metamorphose\Input\Parser;

/**
 * Class YamlParser
 *
 * @package Metamorphose\Input\Parsers
 */
class YamlParser extends Parser {

    const NAME = 'yaml';

    /**
     * @inheritDoc
     */
    public function parseString(string $string): void {

        $dataArray = yaml_parse($string);

        $this->parseArray($dataArray);

    }

}
