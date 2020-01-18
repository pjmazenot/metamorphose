<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input;

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Input\Parsers\CsvParser;
use Metamorphose\Input\Parsers\JsonParser;
use Metamorphose\Input\Parsers\XmlParser;
use Metamorphose\Input\Parsers\YamlParser;

class ParserCollection {

    /** @var ParserInterface[] $parsers */
    protected $parsers = [];

    public function __construct() {

        // Register default parsers
        $this->registerParser(new CsvParser());
        $this->registerParser(new JsonParser());
        $this->registerParser(new XmlParser());
        $this->registerParser(new YamlParser());

    }

    public function registerParser(ParserInterface $parser): void {

        $this->parsers[$parser->getName()] = $parser;

    }

    public function getParser(string $name): ParserInterface {

        if(!isset($this->parsers[$name])) {
            throw new MetamorphoseUndefinedServiceException('Parser "' . $name . '" is not defined');
        }

        return $this->parsers[$name];

    }

}
