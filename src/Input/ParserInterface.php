<?php

namespace Metamorphose\Input;

use Metamorphose\Data\DataSet;

interface ParserInterface {

    public function getName(): string;

    public function getParsedData(): DataSet;

    public function parseArray(array $array);

    public function parseFile(string $filePath);

    public function parseString(string $string);

}
