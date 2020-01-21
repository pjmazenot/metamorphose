<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\TestCase;

use Metamorphose\Metamorphose;
use Metamorphose\Morph\MorphEngine;
use Tests\Codeception\FunctionalTester;

class BaseFunctionalTest {

    protected function runCsvTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.csv';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.csv';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source' => $inputDataPath
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        $this->checkCsvOutput($I, $expectedOutputPath, $output['dest']);

    }

    protected function runJsonTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.json';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source' => $inputDataPath
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        $this->checkJsonOutput($I, $expectedOutputPath, $output['dest']);

    }

    protected function runXmlTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.xml';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.xml';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source' => $inputDataPath
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        $this->checkXmlOutput($I, $expectedOutputPath, $output['dest']);

    }

    protected function runYamlTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.yaml';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.yaml';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source' => $inputDataPath
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        $this->checkYamlOutput($I, $expectedOutputPath, $output['dest']);

    }

    protected function runConvertTest(FunctionalTester $I, string $testName, string $from, string $to) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.' . $from;
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.' . $to;

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source' => $inputDataPath
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        switch ($to) {
            case 'csv':
                $this->checkCsvOutput($I, $expectedOutputPath, $output['dest']);
                break;
            case 'json':
                $this->checkJsonOutput($I, $expectedOutputPath, $output['dest']);
                break;
            case 'xml':
                $this->checkXmlOutput($I, $expectedOutputPath, $output['dest']);
                break;
            case 'yaml':
                $this->checkYamlOutput($I, $expectedOutputPath, $output['dest']);
                break;
        }

    }

    protected function checkTxtOutput(FunctionalTester $I, string $expectedOutputPath, string $output) {

        $I->assertSame(
            file_get_contents($expectedOutputPath),
            $output
        );

    }

    protected function checkCsvOutput(FunctionalTester $I, string $expectedOutputPath, string $output) {

        $I->assertSame(
            file_get_contents($expectedOutputPath),
            $output
        );

    }

    protected function checkJsonOutput(FunctionalTester $I, string $expectedOutputPath, string $output) {

        $I->assertSame(
            json_decode(file_get_contents($expectedOutputPath), true),
            json_decode($output, true)
        );

    }

    protected function checkXmlOutput(FunctionalTester $I, string $expectedOutputPath, string $output) {

        $I->assertSame(
            file_get_contents($expectedOutputPath),
            $output
        );

    }

    protected function checkYamlOutput(FunctionalTester $I, string $expectedOutputPath, string $output) {

        $I->assertSame(
            file_get_contents($expectedOutputPath),
            $output
        );

    }

}