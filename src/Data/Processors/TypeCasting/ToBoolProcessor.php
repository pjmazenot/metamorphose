<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Processors\TypeCasting;

use Metamorphose\Data\DataProcessor;

/**
 * Class ToBoolProcessor
 *
 * @package Metamorphose\Data\Processors\TypeCasting
 */
class ToBoolProcessor extends DataProcessor {

    const NAME = 'to_bool';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        return (bool) $data;

    }

}
