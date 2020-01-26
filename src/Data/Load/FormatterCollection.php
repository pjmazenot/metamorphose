<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Load;

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Data\Load\Formatters\CsvFormatter;
use Metamorphose\Data\Load\Formatters\JsonFormatter;
use Metamorphose\Data\Load\Formatters\XmlFormatter;
use Metamorphose\Data\Load\Formatters\YamlFormatter;

/**
 * Class FormatterCollection
 *
 * @package Metamorphose\Data\Load
 */
class FormatterCollection {

    /** @var FormatterInterface[] $formatters */
    protected $formatters = [];

    /**
     * FormatterCollection constructor.
     */
    public function __construct() {

        // Register default formatters
        $this->registerFormatter(new CsvFormatter());
        $this->registerFormatter(new JsonFormatter());
        $this->registerFormatter(new XmlFormatter());
        $this->registerFormatter(new YamlFormatter());

    }

    /**
     * Get the formatters in the collection
     *
     * @return FormatterInterface[]
     */
    public function getFormatters(): array {

        return $this->formatters;

    }

    /**
     * Register a formatter in the collection
     *
     * @param FormatterInterface $formatter
     */
    public function registerFormatter(FormatterInterface $formatter): void {

        $this->formatters[$formatter->getName()] = $formatter;

    }

    /**
     * Get a formatter from the collection
     *
     * @param string $name
     *
     * @return FormatterInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getFormatter(string $name): FormatterInterface {

        if(!isset($this->formatters[$name])) {
            throw new MetamorphoseUndefinedServiceException('Formatter "' . $name . '" is not defined');
        }

        return $this->formatters[$name];

    }

}

