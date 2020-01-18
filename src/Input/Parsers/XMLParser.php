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

class XMLParser extends Parser {

    const NAME = 'xml';

    public function parseString(string $string): void {

        // @link: https://stackoverflow.com/questions/6578832/how-to-convert-xml-into-array-in-php



        $xml   = simplexml_load_string($string);
        $array = $this->XML2Array($xml);
        $array = array($xml->getName() => $array);

        $this->parseArray($array);

//        $xml   = simplexml_load_string($string);
//        $array = json_decode(json_encode((array) $xml), true);
//        $array = array($xml->getName() => $array);

    }

    function XML2Array(\SimpleXMLElement $parent)
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];

            $node = $element->count() ? $this->XML2Array($element) : trim($element);
        }

        return $array;
    }

}
