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
 * Class ExplodeProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\Strings
 */
class ExplodeProcessor extends Processor {

    const NAME = 'explode';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(empty($params)) {
            return $data;
        }

        $delimiter = array_shift($params);

        return explode($delimiter, $data);

    }

}
