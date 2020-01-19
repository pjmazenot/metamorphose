<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Processors\Json;

use Metamorphose\Data\DataProcessor;

/**
 * Class JsonEncodeProcessor
 *
 * @package Metamorphose\Data\Processors\Json
 */
class JsonEncodeProcessor extends DataProcessor {

    const NAME = 'json_encode';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        return json_encode($data);

    }

}
