<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Output\Formatters;

use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Output\Formatter;

/**
 * Class XmlFormatter
 *
 * @package Metamorphose\Output\Formatters
 */
class XmlFormatter extends Formatter {

    const NAME = 'xml';
    const FORMAT = 'application/xml';

    const CDATA_START = '<![CDATA[';
    const CDATA_END = ']]>';

    protected const CDATA_FAKE_START = '----!CDATA----';
    protected const CDATA_FAKE_END = '----ATADC!----';

    /**
     * Format the data set to an xml string
     *
     * @param DataSet $data
     * @param array   $options
     *
     * @return string
     * @throws MetamorphoseException
     */
    public function format(DataSet $data, array $options = []): string {

        // Get the data array
        $dataArray = $data->getData()->toArray();

        // Check that there is only one root
        if(count($dataArray) > 1) {

            throw new MetamorphoseException('Only one XML root should be defined.');

        }

        $rootName = array_key_first($dataArray);
        $prolog = !empty($options['prolog']) ? $options['prolog'] : '<?xml version="1.0" encoding="utf-8"?>';
        $xmlObject = new \SimpleXMLElement($prolog . '<' . $rootName . '></' . $rootName . '>', LIBXML_NOCDATA);

        // Convert the data array to xml
        $this->arrayToXml($dataArray[$rootName], $xmlObject);

        // Generate the xml string
        $xmlString = $xmlObject->asXML();

        // Replace CDATA sections
        $this->replaceCdataSection($xmlString);

        return $xmlString;

    }

    /**
     * Transform an array into xml
     *
     * @param array $dataArray
     * @param \SimpleXMLElement $xmlObject
     */
    protected function arrayToXml($dataArray, \SimpleXMLElement &$xmlObject): void {

        foreach($dataArray as $key => $value) {

            $key = is_numeric($key) ? 'item' . $key : $key;

            if(is_array($value)) {

                $subNode = $xmlObject->addChild($key);
                $this->arrayToXml($value, $subNode);

            } else {

                // Workaround to allow CDATA section (the string is replace after getting the XML string)
                if(strpos($value, self::CDATA_START) !== false && strpos($value, self::CDATA_END)) {
                    $value = str_replace(
                        [self::CDATA_START, self::CDATA_END],
                        '',
                        $value
                    );
                    $value = self::CDATA_FAKE_START . base64_encode($value) . self::CDATA_FAKE_END;
                }

                $xmlObject->addChild($key, $value);

            }

        }

    }

    /**
     * Replace the CDATA section in the xml string
     *
     * @param string $xmlString
     */
    public function replaceCdataSection(string &$xmlString): void {

        $pattern = str_replace('-', '\-', '/(' . self::CDATA_FAKE_START . '[^' . self::CDATA_FAKE_END . ']*' . self::CDATA_FAKE_END . ')/');
        $xmlString = preg_replace_callback($pattern, function ($matches) {

            $value = str_replace(
                [self::CDATA_FAKE_START, self::CDATA_FAKE_END],
                '',
                $matches[0]
            );
            $value = self::CDATA_START . base64_decode($value) . self::CDATA_END;
            return $value;

        }, $xmlString);

    }

}
