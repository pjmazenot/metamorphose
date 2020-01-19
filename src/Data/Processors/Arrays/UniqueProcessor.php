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

/**
 * Class UniqueProcessor
 *
 * @package Metamorphose\Data\Processors\Arrays
 */
class UniqueProcessor extends DataProcessor {

    const NAME = 'array_unique';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        return array_unique($data);

    }

}
