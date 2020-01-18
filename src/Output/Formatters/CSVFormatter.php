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

class CSVFormatter extends Formatter {

    const NAME = 'csv';
    const FORMAT = 'text/csv';

    public function format(array $data, array $options = []): string {

        if(!empty($options['headers'])) {
            array_unshift($data, $options['headers']);
        }

        $lines = '';
        $totalLines = count($data);
        for($i = 0; $i < $totalLines; $i++) {

            // Putting the keys/values in the right order
            $lineData = $data[$i];
            ksort($lineData);

            $line = '';
            foreach($lineData as &$value) {
                $value = $this->cleanValue($value);
            }
            $line .= '"' . implode('","', $lineData) . '"';
            $lines .= $line . ($i + 1 < $totalLines ? PHP_EOL : '');

        }

        return $lines;

    }

    protected function cleanValue($value) {

        return str_replace('"', '\"', $value);

    }

}
