<?php

namespace Tests\Codeception\TestCase;

use Tests\Codeception\FunctionalTester;

class XmlBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runXmlTest($I, 'xml-basic/rename-fields');

    }

}