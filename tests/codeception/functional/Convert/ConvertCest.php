<?php

namespace Tests\Codeception\Functional\Convert;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class ConvertCest extends BaseFunctionalTest {

    public function testConvertJsonToXml(FunctionalTester $I) {

        $this->runConvertTest($I, 'basic-convert/json-to-xml', 'json', 'xml');

    }

    public function testConvertXmlToJson(FunctionalTester $I) {

        $this->runConvertTest($I, 'basic-convert/xml-to-json', 'xml', 'json');

    }

}