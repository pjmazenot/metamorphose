<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Output\Formatters;

use Metamorphose\Output\Formatter;

/**
 * Class YamlFormatter
 *
 * @package Metamorphose\Output\Formatters
 */
class YamlFormatter extends Formatter {

    const NAME = 'yaml';
    const FORMAT = 'application/x-yaml';

    /**
     * @inheritDoc
     */
    public function format(array $data, array $options = []): string {

        return yaml_emit($data);

    }

}
