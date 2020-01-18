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

use Metamorphose\Input\Parser;

class CsvParser extends Parser {

    const NAME = 'csv';

    public function parseString(string $string): void {

        // @TODO: Improve with https://stackoverflow.com/questions/5249279/file-get-contents-php-fatal-error-allowed-memory-exhausted

        $lines = explode(PHP_EOL, $string);
        $header = str_getcsv(array_shift($lines));
        $columnCount = count($header);
        // TODO: Support line breaks (using the column count | guessing if there is no headers)

        $dataArray = [];
        foreach($lines as $line) {

            $dataArray[] = str_getcsv($line);

        }

        $this->parseArray($dataArray);

    }

}
