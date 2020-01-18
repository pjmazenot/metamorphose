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

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Output\Formatters\CsvFormatter;
use Metamorphose\Output\Formatters\JsonFormatter;
use Metamorphose\Output\Formatters\XmlFormatter;

class FormatterCollection {

    /** @var FormatterInterface[] $formatters */
    protected $formatters = [];

    public function __construct() {

        // Register default formatters
        $this->registerFormatter(new CsvFormatter());
        $this->registerFormatter(new JsonFormatter());
        $this->registerFormatter(new XmlFormatter());

    }

    public function registerFormatter(FormatterInterface $formatter): void {

        $this->formatters[$formatter->getName()] = $formatter;

    }

    public function getFormatter(string $name): FormatterInterface {

        if(!isset($this->formatters[$name])) {
            throw new MetamorphoseUndefinedServiceException('Formatter "' . $name . '" is not defined');
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

