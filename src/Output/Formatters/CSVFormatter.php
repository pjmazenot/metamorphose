<?php

namespace Metamorphose\Output\Formatters;

use Metamorphose\Output\Formatter;

class CSVFormatter extends Formatter {

    const NAME = 'csv';

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
