<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Advanced\Extensions;

use Metamorphose\Metamorphose;
use Tests\Codeception\Functional\Advanced\Extensions\Custom\CustomDataProcessor;
use Tests\Codeception\Functional\Advanced\Extensions\Custom\CustomDataValidator;
use Tests\Codeception\Functional\Advanced\Extensions\Custom\CustomFormatter;
use Tests\Codeception\Functional\Advanced\Extensions\Custom\CustomParser;
use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class ExtensionCest extends BaseFunctionalTest {

    public function testCustomParser(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-parser-contract.json';
        $inputDataPath = $fixturesPath . 'custom-parser-input.txt';
        $expectedOutputPath = $fixturesPath . 'custom-parser-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->services()->registerParser(new CustomParser());
        $metamorphose->extract([
            'source' => [
                'file' => $inputDataPath
            ],
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $this->checkJsonOutput($I, $expectedOutputPath, $output['dest']);

    }

    public function testCustomFormatter(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-formatter-contract.json';
        $inputDataPath = $fixturesPath . 'custom-formatter-input.json';
        $expectedOutputPath = $fixturesPath . 'custom-formatter-expected-output.txt';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->services()->registerFormatter(new CustomFormatter());
        $metamorphose->extract([
            'source' => [
                'file' => $inputDataPath
            ],
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $this->checkTxtOutput($I, $expectedOutputPath, $output['dest']);

    }

    public function testCustomDataProcessor(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-data-processor-contract.json';
        $inputDataPath = $fixturesPath . 'custom-data-processor-input.json';
        $expectedOutputPath = $fixturesPath . 'custom-data-processor-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->services()->registerDataProcessor(new CustomDataProcessor());
        $metamorphose->extract([
            'source' => [
                'file' => $inputDataPath
            ],
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $this->checkJsonOutput($I, $expectedOutputPath, $output['dest']);

    }

    public function testCustomDataValidator(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-extension/';
        $contractPath = $fixturesPath . 'custom-data-validator-contract.json';
        $inputDataPath = $fixturesPath . 'custom-data-validator-input.json';

        try {

            $metamorphose = new Metamorphose($contractPath);
            $metamorphose->services()->registerDataValidator(new CustomDataValidator());
            $metamorphose->extract([
                'source' => [
                    'file' => $inputDataPath
                ],
            ]);
            $metamorphose->transform();

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