<?php

namespace Metamorphose\Input;

use Metamorphose\Data\DataSet;

abstract class Parser implements ParserInterface {

    /** Constant to override with the real name */
    const NAME = '';

    /** @var DataSet $parsedData */
    protected $parsedData;

    public function getName(): string {

        return static::NAME;

    }

    public function getParsedData(): DataSet {

        return $this->parsedData;

    }

    public function parseArray(array $array): void {

        $this->parsedData = new DataSet($array);

    }

    public function parseFile(string $filePath): void {

        $fileContent = file_get_contents($filePath);

        $this->parseString($fileContent);

    }

}
