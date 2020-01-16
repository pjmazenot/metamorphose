<?php

namespace Tests\Codeception\Functional\Extension;

use Metamorphose\Metamorphose;
use Tests\Codeception\Functional\Extension\Custom\CustomDataProcessor;
use Tests\Codeception\Functional\Extension\Custom\CustomDataValidator;
use Tests\Codeception\Functional\Extension\Custom\CustomFormatter;
use Tests\Codeception\Functional\Extension\Custom\CustomParser;
use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class ExtensionCest extends BaseFunctionalTest {

    public function testCustomParser(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-parser-contract.json';
        $inputDataPath = $fixturesPath . 'custom-parser-input.txt';
        $expectedOutputPath = $fixturesPath . 'custom-parser-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->registerParser(new CustomParser());
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkJsonOutput($I, $expectedOutputPath, $output);

    }

    public function testCustomFormatter(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-formatter-contract.json';
        $inputDataPath = $fixturesPath . 'custom-formatter-input.json';
        $expectedOutputPath = $fixturesPath . 'custom-formatter-expected-output.txt';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->registerFormatter(new CustomFormatter());
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkTxtOutput($I, $expectedOutputPath, $output);

    }

    public function testCustomDataProcessor(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-data-processor-contract.json';
        $inputDataPath = $fixturesPath . 'custom-data-processor-input.json';
        $expectedOutputPath = $fixturesPath . 'custom-data-processor-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->registerDataProcessor(new CustomDataProcessor());
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkJsonOutput($I, $expectedOutputPath, $output);

    }

    public function testCustomDataValidator(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-data-validator-contract.json';
        $inputDataPath = $fixturesPath . 'custom-data-validator-input.json';

        try {

            $metamorphose = new Metamorphose($contractPath);
            $metamorphose->registerDataValidator(new CustomDataValidator());
            $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
            $metamorphose->convert();

            // Fail the test if the validator didn't catch the error
            $I->assertTrue(false);

        } catch (\Throwable $e) {

            if(strpos($e->getMessage(), 'Invalid value for the target field') === 0) {

                // Test successful if we catch the right exception
                $I->assertTrue( true);

            } else {

                // Unknown error - fail the test
                $I->assertTrue( false);

            }

        }

    }

}