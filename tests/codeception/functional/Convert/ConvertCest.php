<?php

namespace Tests\Functional\Convert;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class ConvertCest extends BaseFunctionalTest {

    public function testConvertJsonToXml(FunctionalTester $I) {

        $this->runConvertTest($I, 'convert/json-to-xml', 'json', 'xml');

    }

    public function testConvertXmlToJson(FunctionalTester $I) {

        $this->runConvertTest($I, 'convert/xml-to-json', 'xml', 'json');

    }

}