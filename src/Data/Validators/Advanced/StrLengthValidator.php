<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validators\Advanced;

use Metamorphose\Data\DataValidator;

/**
 * Class StrLengthValidator
 *
 * @package Metamorphose\Data\Validators\Advanced
 */
class StrLengthValidator extends DataValidator {

    const NAME = 'str_length';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        $min = array_shift($params);
        $max = array_shift($params);

        if(isset($min) && isset($max)) {

            return $min < strlen($data) && strlen($data) < $max;

        } elseif(isset($min)) {

            return $min < strlen($data);

        } elseif(isset($max)) {

            return strlen($data) < $max;

        }

        return false;

    }

}
