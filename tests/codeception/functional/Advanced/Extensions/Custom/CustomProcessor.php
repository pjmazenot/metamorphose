<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Advanced\Extensions\Custom;

use Metamorphose\Data\Transform\Processor;

class CustomProcessor extends Processor {

    const NAME = 'custom-processor';

    public function process($data, array $params = []) {

        if(is_string($data)) {

            return preg_replace('/[0-9]+/', '', $data);

        } else {

            return $data;

        }

    }

}