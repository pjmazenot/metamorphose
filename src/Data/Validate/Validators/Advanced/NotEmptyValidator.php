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
 * Class NotEmptyValidator
 *
 * @package Metamorphose\Data\Validate\Validators\Advanced
 */
class NotEmptyValidator extends Validator {

    const NAME = 'not_empty';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        return !empty($data);

    }

}
