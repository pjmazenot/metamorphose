<?php

namespace Metamorphose\Output\Formatters;

use Metamorphose\Output\Formatter;

class XMLFormatter extends Formatter {

    const NAME = 'xml';
    const FORMAT = 'application/xml';

    public function format(array $data, array $options = []): string {

        // @link: https://stackoverflow.com/questions/1397036/how-to-convert-array-to-simplexml

        // creating object of SimpleXMLElement
        // @TODO: Get header from input/options

        // Check that there is only one root
        if(count($data) > 1) {
            throw new \Exception('Only one XML root should be defined.');
        }

        $rootName = array_key_first($data);
        $xmlObject = new \SimpleXMLElement('<?xml version="1.0" encoding="utf-8" ?><' . $rootName . '></' . $rootName . '>');

        // function call to convert array to xml
        $this->array_to_xml($data[$rootName], $xmlObject);

        //saving generated xml file
        return $xmlObject->asXML();

    }

    protected function array_to_xml($student_info, &$xmlObject) {
        foreach($student_info as $key => $value) {
            if(is_array($value)) {
                $key = is_numeric($key) ? "item$key" : $key;
                $subnode = $xmlObject->addChild("$key");
                $this->array_to_xml($value, $subnode);
            }
            else {
                $key = is_numeric($key) ? "item$key" : $key;
                $xmlObject->addChild("$key","$value");
            }
        }
    }

}
