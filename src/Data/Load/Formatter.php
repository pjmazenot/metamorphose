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

/**
 * Class Formatter
 *
 * @package Metamorphose\Data\Load
 */
abstract class Formatter implements FormatterInterface {

    /** Constants to override */
    const NAME = '';
    const FORMAT = '';

    /**
     * @inheritDoc
     */
    public function getName(): string {

        return static::NAME;

    }

    /**
     * @inheritDoc
     */
    public function getFormat(): string {

        return static::FORMAT;

    }

}

