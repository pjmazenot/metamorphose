<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Codeception\Functional\Advanced\Extensions\Custom;

use Metamorphose\Data\DataSet;
use Metamorphose\Input\Parser;

class CustomParser extends Parser {

    const NAME = 'custom-parser';

    public function parse($string): DataSet {

        $dataFinalArray = [];
        $dataArray = explode('|', $string);

        foreach($dataArray as $data) {

            list($property, $value) = explode(':', $data);

            $dataFinalArray[$property] = $value;

        }

        return parent::parse($dataFinalArray);

    }

}