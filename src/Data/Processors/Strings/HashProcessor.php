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
 * Class HashProcessor
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class HashProcessor extends DataProcessor {

    const NAME = 'hash';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        if(empty($params)) {
            return $data;
        }

        $algorithm = array_shift($params);

        return hash($algorithm, $data);

    }

}
