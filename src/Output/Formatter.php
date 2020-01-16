<?php

namespace Metamorphose\Output;

abstract class Formatter implements FormatterInterface {

    /** Constants to override */
    const NAME = '';
    const FORMAT = '';

    public function getName(): string {

        return static::NAME;

    }

    public function getFormat(): string {

        return static::FORMAT;

    }

}

