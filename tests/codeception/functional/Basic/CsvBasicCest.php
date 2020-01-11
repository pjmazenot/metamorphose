<?php

namespace Tests\Codeception\TestCase;

use Tests\Codeception\FunctionalTester;

class CsvBasicCest extends BaseFunctionalTest {

    public function testRenameFields(FunctionalTester $I) {

        $this->runCsvTest($I, 'csv-basic/rename-fields');

    }

}