<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform\Processors\Base;

use Metamorphose\Data\Transform\Processor;

/**
 * Class DefaultProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\Base
 */
class DefaultProcessor extends Processor {

    const NAME = 'default';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(!isset($data) && !empty($params)) {

            return array_shift($params);

        } else {

            return $data;

        }

    }

}
