<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Advanced\MultiContract;

use Metamorphose\Metamorphose;
use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class MultiContractOneDestinationCest extends BaseFunctionalTest {

//    public function testMultiContractOneOutput(FunctionalTester $I, string $contractValidator) {
//
//        $fixturesPath = __DIR__ . '/../../_fixtures/advanced-multi-contract/';
//        if(isset($contractValidator)) {
//            $contractValidatorPath = $fixturesPath . $contractValidator;
//        } else {
//            $contractValidatorPath = null;
//        }
//
//        $contractPath = $fixturesPath . 'multi-contract-one-destination-contract.json';
//        $inputData1Path = $fixturesPath . 'multi-contract-one-destination-input-1.json';
//        $inputData2Path = $fixturesPath . 'multi-contract-one-destination-input-2.xml';
//        $expectedOutput1Path = $fixturesPath . 'multi-contract-one-destination-expected-output.json';
//
//        $metamorphose = new Metamorphose($contractPath, $contractValidatorPath);
//        $metamorphose->extract([
//            'source1' => $inputData1Path,
//            'source2' => $inputData2Path,
//        ]);
//        $metamorphose->transform();
//        $output = $metamorphose->load();
//
//        $I->debug($output);
//
//        $this->checkJsonOutput($I, $expectedOutput1Path, $output['dest']);
//
//    }
//
//    public function testMultiContractOneOutputWithContractValidatorSuccess(FunctionalTester $I) {
//
//        $this->testMultiContractOneOutput($I, 'multi-contract-one-destination-contract-validator-success.json');
//
//    }
//
//    public function testMultiContractOneOutputWithContractValidatorFail(FunctionalTester $I) {
//
//        try {
//
//            $this->testMultiContractOneOutput($I, 'multi-contract-one-destination-contract-validator-fail.json');
//
//            // Fail the test if the validator didn't catch the error
//            $I->assertTrue(false);
//
//        } catch (\Throwable $e) {
//
//            if(
//                strpos($e->getMessage(), 'The contract is not valid.') === 0
//                && strpos($e->getMessage(), 'firstname, lastname') > 0
//            ) {
//
//                // Test successful if we catch the right exception
//                $I->assertTrue( true);
//
//            } else {
//
//                // Unknown error - fail the test
//                $I->assertTrue( false);
//
//            }
//
//        }
//
//    }

}