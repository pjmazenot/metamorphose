<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform\Processors\Arrays;

use Metamorphose\Data\Transform\Processor;

/**
 * Class ImplodeProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\Arrays
 */
class ImplodeProcessor extends Processor {

    const NAME = 'implode';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(empty($params)) {
            return $data;
        }

        $glue = array_shift($params);

        return explode($glue, $data);

    }

}
