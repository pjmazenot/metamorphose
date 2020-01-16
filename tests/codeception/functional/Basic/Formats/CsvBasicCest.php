<?php

namespace Tests\Codeception\Functional\Basic\Formats;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class CsvBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runCsvTest($I, 'basic-csv/rename-fields');

    }

}