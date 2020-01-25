<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Processors\Strings;

use Metamorphose\Data\DataProcessor;

/**
 * Class WrapperProcessor
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class WrapperProcessor extends DataProcessor {

    const NAME = 'str_wrapper';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(count($params) < 2) {
            return $data;
        }

        $left = array_shift($params);
        $right = array_shift($params);

        return $left . $data . $right;

    }

}
