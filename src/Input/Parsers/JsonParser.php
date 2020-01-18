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

class JsonParser extends Parser {

    const NAME = 'json';

    public function parseString(string $string): void {

        $dataArray = json_decode($string, true);

        $this->parseArray($dataArray);

    }

}
