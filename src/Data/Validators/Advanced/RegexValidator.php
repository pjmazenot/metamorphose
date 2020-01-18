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

class RegexValidator extends DataValidator {

    const NAME = 'regex';

    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        // @TODO: Add try/catch in case of bad regex?
        $regex = array_shift($params);

        return preg_match($regex, $data);

    }

}
