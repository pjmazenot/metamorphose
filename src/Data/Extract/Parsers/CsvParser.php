<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Extract\Parsers;

use Metamorphose\Data\DataSet;
use Metamorphose\Data\Extract\Parser;

/**
 * Class CsvParser
 *
 * @package Metamorphose\Data\Extract\Parsers
 */
class CsvParser extends Parser {

    const NAME = 'csv';

    /**
     * Parse the data as CSV
     *
     * @param array|string $data
     * @param array $options
     *
     * @return DataSet
     */
    public function parse($data, array $options = []): DataSet {

        $delimiter = $options['delimiter'] ?? ',';
        $enclosure = $options['enclosure'] ?? '"';
        $escape = $options['escape'] ?? '\\';
        $noheaders = $options['noheaders'] ?? false;

        $lines = explode(PHP_EOL, $data);
        if(!$noheaders) {
            str_getcsv(array_shift($lines));
        }

        $dataArray = [];
        $currentRow = 0;
        foreach($lines as $index => $line) {

            // Since we can be processing multiline we skip those indexes
            if(($nextIndex ?? 0) > $index) {
                continue;
            }

            $lineDone = false;
            $nextIndex = $index;
            $parsedLine = [];
            while(!$lineDone) {

                // Get the line parsed and parse it
                $nextLine = $lines[$nextIndex];
                $parsedNextLine = str_getcsv($nextLine, $delimiter, $enclosure, $escape);

                // If $parsedLine is not empty we have missing columns in the last row
                if(!empty($parsedLine)) {

                    // The next part of this line is the last part of the last processed column
                    $nextPart = array_shift($parsedNextLine);

                    // The str_getcsv function keep the closing delimiter in the next part so if it's not escaped we remove it
                    if(
                        substr($nextPart, -1) === $enclosure
                        && substr($nextPart, -2) !== $escape . $enclosure
                    ) {
                        $nextPart = substr($nextPart, 0, -1);
                    }

                    // Update the last column of the current row
                    $parsedLine[count($parsedLine) - 1] .= PHP_EOL . $nextPart;
                }

                // Add the remaining columns to the row (if any)
                $parsedLine = array_merge($parsedLine, $parsedNextLine);

                // Check the status of the enclosure
                $isEnclosureStillOpen = $isEnclosureStillOpen ?? false;
                $isEnclosureOpen = substr_count(str_replace($escape . $enclosure, '', $nextLine), $enclosure) % 2 !== 0;

                if(
                    !$isEnclosureOpen && !$isEnclosureStillOpen
                    || $isEnclosureOpen && $isEnclosureStillOpen
                ) {

                    // If the global enclosure of the full line was not opened or is closed we are done with this line
                    $lineDone = true;
                    $isEnclosureStillOpen = false;

                } else {

                    // If the global enclosure of the full line is still opened let's continue to process this line
                    $isEnclosureStillOpen = true;

                }

                $nextIndex++;

            }

            $dataArray[$currentRow] = $parsedLine;
            $currentRow++;

        }

        return parent::parse($dataArray);

    }

}
