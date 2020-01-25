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
 * Class ConcatProcessor
 *
 * The concat processor "loses" the current value.
 * To prevent this use one or more of these other processors:
 * - str_before @TODO
 * - str_after @TODO
 * - str_wrapper
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class ConcatProcessor extends DataProcessor {

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
