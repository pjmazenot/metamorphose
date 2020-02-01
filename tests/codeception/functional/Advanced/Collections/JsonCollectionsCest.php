<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Basic\Collections;

use Tests\Codeception\FunctionalTester;
use Tests\Codeception\TestCase\BaseFunctionalTest;

class JsonCollectionsCest extends BaseFunctionalTest {

    public function testCollectionInObject(FunctionalTester $I) {

        $this->runJsonTest($I, 'advanced-collections/json-collection-in-object');

    }

}