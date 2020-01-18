<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Output;

use Metamorphose\Output\Formatters\CSVFormatter;
use Metamorphose\Output\Formatters\JSONFormatter;
use Metamorphose\Output\Formatters\XMLFormatter;

class FormatterCollection {

    /** @var FormatterInterface[] $formatters */
    protected $formatters = [];

    public function __construct() {

        // Register default formatters
        $this->registerFormatter(new CSVFormatter());
        $this->registerFormatter(new JSONFormatter());
        $this->registerFormatter(new XMLFormatter());

    }

    public function registerFormatter(FormatterInterface $formatter): void {

        $this->formatters[$formatter->getName()] = $formatter;

    }

    public function getFormatter(string $name): FormatterInterface {

        if(!isset($this->formatters[$name])) {
            throw new \Exception('Formatter "' . $name . '" is not defined');
        }

        return $this->formatters[$name];

    }

    /**
     * @return FormatterInterface[]
     */
    public function getFormatters(): array {

        return $this->formatters;

    }

}

