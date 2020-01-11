<?php

namespace Metamorphose\Output;

use Metamorphose\Output\Formatters\CSVFormatter;
use Metamorphose\Output\Formatters\JSONFormatter;
use Metamorphose\Output\Formatters\XMLFormatter;

class FormatterCollection {

    protected $formatters = [];

    public function __construct() {

        // Register default formatters
        $this->registerFormatter(CSVFormatter::NAME, new CSVFormatter());
        $this->registerFormatter(JSONFormatter::NAME, new JSONFormatter());
        $this->registerFormatter(XMLFormatter::NAME, new XMLFormatter());

    }

    public function registerFormatter(string $name, FormatterInterface $formatter): void {

        $this->formatters[$name] = $formatter;

    }

    public function getFormatter(string $name): FormatterInterface {

        if(!isset($this->formatters[$name])) {
            throw new \Exception('Formatter "' . $name . '" is not defined');
        }

        return $this->formatters[$name];

    }

}

