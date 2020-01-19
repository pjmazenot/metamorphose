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

/**
 * Class LessThanValidator
 *
 * @package Metamorphose\Data\Validators\Operators
 */
class LessThanValidator extends DataValidator {

    const NAME = 'lt';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        $expected = array_shift($params);

        return $data < $expected;

    }

}
