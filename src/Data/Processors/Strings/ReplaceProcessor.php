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
 * Class ReplaceProcessor
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class ReplaceProcessor extends DataProcessor {

    const NAME = 'replace';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(count($params) < 2) {
            return $data;
        }

        $search = array_shift($params);
        $replace = array_shift($params);

        return str_replace($search, $replace, $data);

    }

}
