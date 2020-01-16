<?php

namespace Metamorphose\Data;

abstract class DataProcessor implements DataProcessorInterface {

    /** Constant to override with the real name */
    const NAME = '';

    public function getName(): string {

        return static::NAME;

    }

}
