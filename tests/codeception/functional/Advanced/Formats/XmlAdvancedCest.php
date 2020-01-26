<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Basic\Formats;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class XmlAdvancedCest extends BaseFunctionalTest {

    public function testCustomAttributes(FunctionalTester $I) {

        $this->runXmlTest($I, 'advanced-xml/custom-attributes');

    }

    public function testCustomProlog(FunctionalTester $I) {

        $this->runXmlTest($I, 'advanced-xml/custom-prolog');

    }

    public function testOutputCdata(FunctionalTester $I) {

        $this->runXmlTest($I, 'advanced-xml/output-cdata');

    }

}