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

/**
 * Class BoolValidator
 *
 * @package Metamorphose\Data\Validators\Types
 */
class BoolValidator extends DataValidator {

    const NAME = 'bool';

    /**
     * @inheritDoc
     */
    public function validate($data, array $params = []): bool {

        return is_bool($data);

    }

}
