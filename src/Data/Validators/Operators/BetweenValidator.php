<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validators\Operators;

use Metamorphose\Data\DataValidator;

class BetweenValidator extends DataValidator {

    const NAME = 'between';

    public function validate($data, array $params = []): bool {

        if(count($params) < 2) {
            return false;
        }

        $expected1 = array_shift($params);
        $expected2 = array_shift($params);

        if($expected1 < $expected2) {

            return $expected1 <= $data && $data <= $expected2;

        } else {

            return $expected2 <= $data && $data <= $expected2;

        }

    }

}
