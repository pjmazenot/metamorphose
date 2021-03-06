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
use Metamorphose\Data\Load\Formatter;

class CustomFormatter extends Formatter {

    const NAME = 'custom-formatter';

    public function format(DataSet $data, array $options = []): string {

        $data = $data->getData()->toArray();
        $finalData = [];
        foreach($data as $property => $value) {

            $finalData[] = $property . ':' . $value;

        }

        return implode('|', $finalData);

    }

}