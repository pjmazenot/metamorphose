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
use Metamorphose\Exceptions\MetamorphoseValidateException;

/**
 * Class RegexValidator
 *
 * @package Metamorphose\Data\Validate\Validators\Advanced
 */
class RegexValidator extends Validator {

    const NAME = 'regex';

    /**
     * Validate the data using a regex
     *
     * @param mixed $data
     * @param array $params
     *
     * @return bool
     * @throws MetamorphoseValidateException
     */
    public function validate($data, array $params = []): bool {

        if(empty($params)) {
            return false;
        }

        $regex = array_shift($params);

        $match = preg_match($regex, $data);

        if($match === false) {

            throw new MetamorphoseValidateException('Error trying to match the regex' . $regex);

        }

        return (bool) $match;

    }

}
