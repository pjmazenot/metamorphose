<?php

namespace Metamorphose\Input\Parsers;

use Metamorphose\Input\Parser;

class JSONParser extends Parser {

    const NAME = 'json';

    public function parseString(string $string): void {

        $dataArray = json_decode($string, true);

        $this->parseArray($dataArray);

    }

}
