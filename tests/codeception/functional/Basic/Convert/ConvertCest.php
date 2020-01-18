<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Basic\Convert;

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