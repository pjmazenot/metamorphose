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

/**
 * Interface FormatterInterface
 *
 * @package Metamorphose\Output
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
     * @param array $data
     * @param array $options
     *
     * @return string
     */
    public function format(array $data, array $options = []): string;

}
