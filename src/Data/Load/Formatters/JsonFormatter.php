<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load\Formatters;

use Metamorphose\Data\DataSet;
use Metamorphose\Data\Load\Formatter;

/**
 * Class JsonFormatter
 *
 * @package Metamorphose\Data\Load\Formatters
 */
class JsonFormatter extends Formatter {

    const NAME = 'json';
    const FORMAT = 'application/json';

    /**
     * @inheritDoc
     */
    public function format(DataSet $data, array $options = []): string {

        return json_encode($data->getData()->toArray());

    }

}
