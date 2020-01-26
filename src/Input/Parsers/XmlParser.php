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

use Metamorphose\Data\DataSet;
use Metamorphose\Input\Parser;

/**
 * Class XmlParser
 *
 * @package Metamorphose\Input\Parsers
 */
class XmlParser extends Parser {

    const NAME = 'xml';

    /**
     * Parse the data as XML
     *
     * @param array|string $data
     * @param array        $options
     *
     * @return DataSet
     */
    public function parse($data, array $options = []): DataSet {

        // Load the data into a SimpleXMLElement
        $xml = new \SimpleXMLElement($data, LIBXML_NOCDATA);

        // Transform the SimpleXMLElement to an array
        $xmlArray = $this->xmlToArray($xml);

        // Add the root level
        $dataArray = [
            $xml->getName() => $xmlArray,
        ];

        return parent::parse($dataArray);

    }

    /**
     * Transform a SimpleXMLElement object to an array
     *
     * @param \SimpleXMLElement $xml
     *
     * @return array
     */
    public function xmlToArray(\SimpleXMLElement $xml): array {

        $xmlArray = [
            '@attributes' => [],
            'value' => null,
        ];

        $attributes = $xml->attributes();

        if ($attributes->count() > 0) {

            foreach ($attributes as $attributeName => $attributeValue) {

                $xmlArray['@attributes'][$attributeName] = $attributeValue;

            }

        }

        $children = $xml->children();

        if ($children->count() === 0) {

            $xmlArray['value'] = trim((string)$xml);

        } else {

            foreach ($children as $childName => $childValue) {

                $xmlArray['value'][$childName] = $this->XmlToArray($childValue);

            }

        }

        return $xmlArray;

    }

}
