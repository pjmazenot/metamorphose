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
 * Class CsvFormatter
 *
 * @package Metamorphose\Data\Load\Formatters
 */
class CsvFormatter extends Formatter {

    const NAME = 'csv';
    const FORMAT = 'text/csv';

    /**
     * @inheritDoc
     */
    public function format(DataSet $data, array $options = []): string {

        $data = $data->getData()->toArray();

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
                $value = $this->cleanValue((string) $value);
            }
            $line .= '"' . implode('","', $lineData) . '"';
            $lines .= $line . ($i + 1 < $totalLines ? PHP_EOL : '');

        }

        return $lines;

    }

    /**
     * Clean the value
     *
     * @param string $value
     *
     * @return string
     */
    protected function cleanValue(string $value): string {

        return str_replace('"', '\"', $value);

    }

}
