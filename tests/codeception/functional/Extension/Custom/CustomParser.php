<?php

namespace Tests\Codeception\Functional\Extension\Custom;

use Metamorphose\Input\Parser;

class CustomParser extends Parser {

    const NAME = 'custom-parser';

    public function parseString(string $string): void {

        $dataFinalArray = [];
        $dataArray = explode('|', $string);

        foreach($dataArray as $data) {

            list($property, $value) = explode(':', $data);

            $dataFinalArray[$property] = $value;

        }

        $this->parseArray($dataFinalArray);

    }

}