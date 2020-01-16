<?php

namespace Tests\Codeception\Functional\Basic;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class JsonBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/rename-fields');

    }

    public function testMultiLevelsFrom(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/multi-levels-from');

    }

    public function testMultiLevelsTo(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/multi-levels-to');

    }

    public function testMultiLevelsFromTo(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/multi-levels-from-to');

    }

    public function testMultiLevelsMixed(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/multi-levels-mixed');

    }

    public function testCollectionRenameFields(FunctionalTester $I) {

        $this->runJsonTest($I, 'basic-json/collection-rename-fields');

    }

}