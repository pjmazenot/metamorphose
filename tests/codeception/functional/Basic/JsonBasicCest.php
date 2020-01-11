<?php

namespace Tests\Codeception\TestCase;

use Tests\Codeception\FunctionalTester;

class JsonBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/rename-fields');

    }

    public function testMultiLevelsFrom(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/multi-levels-from');

    }

    public function testMultiLevelsTo(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/multi-levels-to');

    }

    public function testMultiLevelsFromTo(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/multi-levels-from-to');

    }

    public function testMultiLevelsMixed(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/multi-levels-mixed');

    }

    public function testCollectionRenameFields(FunctionalTester $I) {

        $this->runJsonTest($I, 'json-basic/collection-rename-fields');

    }

}