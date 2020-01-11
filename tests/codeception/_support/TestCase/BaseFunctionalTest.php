<?php

namespace Tests\Codeception\TestCase;

use Metamorphose\Metamorphose;
use Tests\Codeception\FunctionalTester;

class BaseFunctionalTest {

    protected function runCsvTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.csv';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.csv';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkCsvOutput($I, $expectedOutputPath, $output);

    }

    protected function runJsonTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.json';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkJsonOutput($I, $expectedOutputPath, $output);

    }

    protected function runXmlTest(FunctionalTester $I, string $testName) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.xml';
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.xml';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        $this->checkXmlOutput($I, $expectedOutputPath, $output);

    }

    protected function runConvertTest(FunctionalTester $I, string $testName, string $from, string $to) {

        $fixturesPath = __DIR__ . '/../../functional/_fixtures/';
        $contractPath = $fixturesPath . $testName . '-contract.json';
        $inputDataPath = $fixturesPath . $testName . '-input.' . $from;
        $expectedOutputPath = $fixturesPath . $testName . '-expected-output.' . $to;

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->load(Metamorphose::SOURCE_TYPE_FILE, $inputDataPath);
        $output = $metamorphose->convert();

        switch ($to) {
            case 'csv':
                $this->checkCsvOutput($I, $expectedOutputPath, $output);
                break;
            case 'json':
                $this->checkJsonOutput($I, $expectedOutputPath, $output);
                break;
            case 'xml':
                $this->checkXmlOutput($I, $expectedOutputPath, $output);
                break;
        }

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

}