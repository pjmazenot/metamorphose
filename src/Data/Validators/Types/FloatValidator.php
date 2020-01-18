<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validators\Types;

use Metamorphose\Data\DataValidator;

class FloatValidator extends DataValidator {

    const NAME = 'float';

    public function validate($data, array $params = []): bool {

        return is_float($data);

    }

}
