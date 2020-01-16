<?php

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
