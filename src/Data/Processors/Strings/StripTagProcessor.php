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
 * Class StripTagProcessor
 *
 * @package Metamorphose\Data\Processors\Strings
 */
class StripTagProcessor extends DataProcessor {

    const NAME = 'strip_tags';

    /**
     * @inheritDoc
     */
    public function process($data, array $params = []) {

        $allowedTag = array_shift($params);

        return strip_tags($data, $allowedTag);

    }

}
