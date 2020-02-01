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
 * Class ValueProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\Base
 */
class ValueProcessor extends Processor {

    const NAME = 'value';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(empty($params)) {

            return null;

        } else {

            return array_shift($params);

        }

    }

}
