<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Processors\Arrays;

use Metamorphose\Data\DataProcessor;

class ImplodeProcessor extends DataProcessor {

    const NAME = 'implode';

    public function process($data, array $params = []) {

        if(empty($params)) {
            return $data;
        }

        $glue = array_shift($params);

        return explode($glue, $data);

    }

}
