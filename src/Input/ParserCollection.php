<?php

namespace Metamorphose\Input;

use Metamorphose\Input\Parsers\CSVParser;
use Metamorphose\Input\Parsers\JSONParser;
use Metamorphose\Input\Parsers\XMLParser;

class ParserCollection {

    /** @var ParserInterface[] $parsers */
    protected $parsers = [];

    public function __construct() {

        // Register default parsers
        $this->registerParser(new CSVParser());
        $this->registerParser(new JSONParser());
        $this->registerParser(new XMLParser());

    }

    public function registerParser(ParserInterface $parser): void {

        $this->parsers[$parser->getName()] = $parser;

    }

    public function getParser(string $name): ParserInterface {

        if(!isset($this->parsers[$name])) {
            throw new \Exception('Parser "' . $name . '" is not defined');
        }

        return $this->parsers[$name];

    }

}
