<?php

namespace Metamorphose\Input\Parsers;

use Metamorphose\Data\DataSet;
use Metamorphose\Input\Parser;

class JSONParser extends Parser {

    const NAME = 'json';

    // @TODO: Keep this?
    public function parseArray(array $array): void {

        $this->parsedData = new DataSet($array);

    }

    public function parseFile(string $filePath): void {

        $fileContent = file_get_contents($filePath);

        $this->parseString($fileContent);

    }

    public function parseString(string $string): void {

        $dataArray = json_decode($string, true);

        $this->parseArray($dataArray);

    }

}
