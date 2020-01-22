<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input\Parsers;

use Metamorphose\Data\DataSet;
use Metamorphose\Input\Parser;

/**
 * Class JsonParser
 *
 * @package Metamorphose\Input\Parsers
 */
class JsonParser extends Parser {

    const NAME = 'json';

    /**
     * Parse the data as JSON
     *
     * @param array|string $data
     * @param array $options
     *
     * @return DataSet
     */
    public function parse($data, array $options = []): DataSet {

        $dataArray = json_decode($data, true);

        return parent::parse($dataArray);

    }

}
