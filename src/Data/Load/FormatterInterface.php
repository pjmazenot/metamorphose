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

use Metamorphose\Data\DataSet;
use Metamorphose\Exceptions\MetamorphoseFormatterException;

/**
 * Interface FormatterInterface
 *
 * @package Metamorphose\Data\Load
 */
interface FormatterInterface {

    /**
     * Get the name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get the supported output format
     *
     * @return string
     */
    public function getFormat(): string;

    /**
     * Format the data
     *
     * @param DataSet $data
     * @param array $options
     *
     * @return string
     * @throws MetamorphoseFormatterException
     */
    public function format(DataSet $data, array $options = []): string;

}
