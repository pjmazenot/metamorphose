<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Unit\Data\Transform\Parsers;

use Metamorphose\Data\Extract\Parsers\CsvParser;
use Tests\Codeception\TestCase\BaseUnitTest;

class CsvParserTest extends BaseUnitTest {

    protected $fixturesPath = __DIR__ . '/../../../_fixtures/data/transform/parsers/csv/';
    protected $simpleCsvExpectedOutput = [
        0 => [
            0 => '1',
            1 => 'John',
            2 => 'Smith',
        ],
        1 => [
            0 => '2',
            1 => 'Mark',
            2 => 'Jones',
        ],
    ];
    protected $advancedCsvExpectedOutput = [
        0 => [
            0 => '1',
            1 => 'John',
            2 => 'Smith',
            3 => 'John Smith is' . PHP_EOL . 'THE BEST' . PHP_EOL . 'test user',
        ],
        1 => [
            0 => '2',
            1 => 'Mark',
            2 => 'Jones',
            3 => 'But Mark Jones is' . PHP_EOL . 'NOT BAD' . PHP_EOL . 'either',
        ],
    ];
    protected $advancedCsvExpectedOutput2 = [
        0 => [
            0 => '1',
            1 => 'John',
            2 => 'Smith',
            3 => 'John Smith is' . PHP_EOL . 'THE BEST' . PHP_EOL . 'test user',
            4 => '1',
            5 => 'A two' . PHP_EOL . 'lines description',
        ],
        1 => [
            0 => '2',
            1 => 'Mark',
            2 => 'Jones',
            3 => 'But Mark Jones is' . PHP_EOL . 'NOT BAD' . PHP_EOL . 'either',
            4 => '0',
            5 => 'A two' . PHP_EOL . 'lines description',
        ],
    ];

    public function testParseSimpleCsvWithDefaults() {

        $this->testParseCsv(
            'simple-with-defaults.csv',
            [],
            $this->simpleCsvExpectedOutput
        );

    }

    public function testParseSimpleCsvNoHeaders() {

        $this->testParseCsv(
            'simple-no-headers.csv',
            [
                'noheaders' => true,
            ],
            $this->simpleCsvExpectedOutput
        );

    }

    public function testParseAdvancedWithOneMultilineColumn() {

        $this->testParseCsv(
            'advanced-with-one-multiline-column.csv',
            [],
            $this->advancedCsvExpectedOutput
        );

    }

    public function testParseAdvancedWithManyMultilineColumns() {

        $this->testParseCsv(
            'advanced-with-many-multiline-columns.csv',
            [],
            $this->advancedCsvExpectedOutput2
        );

    }

    protected function testParseCsv(string $sourceFileName, array $options, array $expectedResult) {

        $parser = new CsvParser();
        $parsedDataSet = $parser->parse(file_get_contents($this->fixturesPath . $sourceFileName), $options);
        $parsedArray = $parsedDataSet->getData()->toArray();

        $this->tester->debug($parsedArray);

        $this->tester->assertSame($expectedResult, $parsedArray);

    }

}