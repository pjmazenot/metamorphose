<?php

namespace Tests\Codeception\Functional\Basic\Formats;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class XmlBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runXmlTest($I, 'basic-xml/rename-fields');

    }

}