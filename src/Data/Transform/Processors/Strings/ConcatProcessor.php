<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform\Processors\Strings;

use Metamorphose\Data\Transform\Processor;

/**
 * Class ConcatProcessor
 *
 * The concat processor "loses" the current value.
 * To prevent this use one or more of these other processors:
 * - str_before @TODO
 * - str_after @TODO
 * - str_wrapper
 *
 * @package Metamorphose\Data\Transform\Processors\Strings
 */
class ConcatProcessor extends Processor {

    const NAME = 'concat';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(empty($params)) {
            return $data;
        }

        return implode($params);

    }

}
