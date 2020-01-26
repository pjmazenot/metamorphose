<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform\Processors\TypeCasting;

use Metamorphose\Data\Transform\Processor;

/**
 * Class ToStringProcessor
 *
 * @package Metamorphose\Data\Transform\Processors\TypeCasting
 */
class ToStringProcessor extends Processor {

    const NAME = 'to_string';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        return (string) $data;

    }

}
