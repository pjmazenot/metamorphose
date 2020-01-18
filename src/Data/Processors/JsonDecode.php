<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Processors;

use Metamorphose\Data\DataProcessor;

class JsonDecode extends DataProcessor {

    const NAME = 'json_decode';

    const TO_ARRAY = 'array';
    const TO_OBJECT = 'object';

    public function process($data, array $params = []) {

        if(is_string($data)) {

            if (!empty($params[0]) && $params[0] === self::TO_ARRAY) {

                return json_decode($data, true);

            } else {  // Default = TO_OBJECT

                return json_decode($data);

            }

        } else {

            return null;

        }

    }

}
