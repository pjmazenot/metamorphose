<?php

namespace Metamorphose\Output;

abstract class Formatter implements FormatterInterface {

    /** Constants to override */
    const NAME = '';

    public function getName(): string {

        return static::NAME;

    }
}

