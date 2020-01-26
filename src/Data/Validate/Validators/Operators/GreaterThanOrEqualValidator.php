<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validate\Validators\Operators;

use Metamorphose\Data\Validate\Validator;

/**
 * Class GreaterThanOrEqualValidator
 *
 * @package Metamorphose\Data\Validate\Validators\Operators
 */
class GreaterThanOrEqualValidator extends Validator {

    const NAME = 'gte';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        $expected = array_shift($params);

        return $data >= $expected;

    }

}
