<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform\Processors\Json;

use Metamorphose\Data\Transform\Processor;

/**
 * Class JsonDecodeProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\Json
 */
class JsonDecodeProcessor extends Processor {

    const NAME = 'json_decode';

    const TO_ARRAY = 'array';
    const TO_OBJECT = 'object';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(is_string($data)) {

            $toType = array_shift($params);

            if (!empty($toType) && $toType === self::TO_ARRAY) {

                return json_decode($data, true);

            } else {  // Default = TO_OBJECT

                return json_decode($data);

            }

        } else {

            return null;

        }

    }

}
