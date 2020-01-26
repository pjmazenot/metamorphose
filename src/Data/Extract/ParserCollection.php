<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Extract;

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Data\Extract\Parsers\CsvParser;
use Metamorphose\Data\Extract\Parsers\JsonParser;
use Metamorphose\Data\Extract\Parsers\XmlParser;
use Metamorphose\Data\Extract\Parsers\YamlParser;

/**
 * Class ParserCollection
 *
 * @package Metamorphose\Data\Extract
 */
class ParserCollection {

    /** @var ParserInterface[] $parsers */
    protected $parsers = [];

    /**
     * ParserCollection constructor.
     */
    public function __construct() {

        // Register default parsers
        $this->registerParser(new CsvParser());
        $this->registerParser(new JsonParser());
        $this->registerParser(new XmlParser());
        $this->registerParser(new YamlParser());

    }

    /**
     * Register a parser in the collection
     *
     * @param ParserInterface $parser
     */
    public function registerParser(ParserInterface $parser): void {

        $this->parsers[$parser->getName()] = $parser;

    }

    /**
     * Get a parser from the collection
     *
     * @param string $name
     *
     * @return ParserInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getParser(string $name): ParserInterface {

        if(!isset($this->parsers[$name])) {

            throw new MetamorphoseUndefinedServiceException('Parser "' . $name . '" is not defined');

        }

        return $this->parsers[$name];

    }

}
