<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Advanced\MultiSource;

use Metamorphose\Metamorphose;
use Metamorphose\Core\Engine;
use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class MultiSourceCest extends BaseFunctionalTest {

    public function testMultiSourceOneOutput(FunctionalTester $I) {

        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-multi-source/';

        $contractPath = $fixturesPath . 'multi-source-one-output-contract.json';
        $inputData1Path = $fixturesPath . 'multi-source-one-output-input-1.json';
        $inputData2Path = $fixturesPath . 'multi-source-one-output-input-2.xml';
        $expectedOutput1Path = $fixturesPath . 'multi-source-one-output-expected-output.json';

        $metamorphose = new Metamorphose($contractPath);
        $metamorphose->extract([
            'source1' => [
                'file' => $inputData1Path
            ],
            'source2' => [
                'file' => $inputData2Path
            ],
        ]);
        $metamorphose->transform();
        $output = $metamorphose->load();

        $I->debug($output);

        $this->checkJsonOutput($I, $expectedOutput1Path, $output['dest']);

    }

}