<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validate\Validators\Advanced;

use Metamorphose\Data\Validate\Validator;

/**
 * Class EnumValidator
 *
 * @package Metamorphose\Data\Validate\Validators\Advanced
 */
class EnumValidator extends Validator {

    const NAME = 'enum';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        return in_array($data, $params);

    }

}
