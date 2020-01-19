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
 * Class ExplodeProcessor
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class ExplodeProcessor extends DataProcessor {

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
