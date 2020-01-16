<?php

namespace Tests\Codeception\Functional\Advanced\MultiSource;

use Metamorphose\Metamorphose;
use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class MultiSourceCest extends BaseFunctionalTest {

    public function testMultiSourceWithValidationSuccess(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-multi-source/';
        $contractValidatorPath = $fixturesPath . 'multi-source-validation-success-contract-validator.json';

        // Scenario 1 - success
        $contract1Path = $fixturesPath . 'multi-source-validation-success-contract-1.json';
        $inputData1Path = $fixturesPath . 'multi-source-validation-success-input-1.json';
        $expectedOutput1Path = $fixturesPath . 'multi-source-validation-success-expected-output-1.json';

        $metamorphose = new Metamorphose($contract1Path, $contractValidatorPath);
        $metamorphose->validateContract();
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputData1Path);
        $output = $metamorphose->convert();

        $this->checkJsonOutput($I, $expectedOutput1Path, $output);

        // Scenario 2 - success
        $contract2Path = $fixturesPath . 'multi-source-validation-success-contract-2.json';
        $inputData2Path = $fixturesPath . 'multi-source-validation-success-input-2.xml';
        $expectedOutput2Path = $fixturesPath . 'multi-source-validation-success-expected-output-2.json';

        $metamorphose = new Metamorphose($contract2Path, $contractValidatorPath);
        $metamorphose->validateContract();
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputData2Path);
        $output = $metamorphose->convert();

        $this->checkJsonOutput($I, $expectedOutput2Path, $output);

    }

    public function testMultiSourceWithValidationFail(FunctionalTester $I) {

        try {

            $fixturesPath = __DIR__ . '/../../_fixtures/advanced-multi-source/';
            $contractValidatorPath = $fixturesPath . 'multi-source-validation-fail-contract-validator.json';

            // Scenario 1 - success
            $contract1Path = $fixturesPath . 'multi-source-validation-fail-contract-1.json';

            $metamorphose = new Metamorphose($contract1Path, $contractValidatorPath);
            $metamorphose->validateContract();

            // Scenario 2 - fail
            $contract2Path = $fixturesPath . 'multi-source-validation-fail-contract-2.json';

            $metamorphose = new Metamorphose($contract2Path, $contractValidatorPath);
            $metamorphose->validateContract();

            // Fail the test if the validator didn't catch the error
            $I->assertTrue(false);

        } catch (\Throwable $e) {

            if(
                strpos($e->getMessage(), 'The contract is not valid.') === 0
                && strpos($e->getMessage(), 'firstname, lastname') > 0
            ) {

                // Test successful if we catch the right exception
                $I->assertTrue( true);

            } else {

                // Unknown error - fail the test
                $I->assertTrue( false);

            }

        }

    }

}