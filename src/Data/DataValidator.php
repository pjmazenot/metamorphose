<?php

namespace Metamorphose\Data;

abstract class DataValidator implements DataValidatorInterface {

    /** Constant to override with the real name */
    const NAME = '';

    public function getName(): string {

        return static::NAME;

    }

}
