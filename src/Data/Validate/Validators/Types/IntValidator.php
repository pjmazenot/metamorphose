<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validate\Validators\Types;

use Metamorphose\Data\Validate\Validator;

/**
 * Class IntValidator
 *
 * @package Metamorphose\Data\Validate\Validators\Types
 */
class IntValidator extends Validator {

    const NAME = 'int';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        return is_int($data);

    }

}
