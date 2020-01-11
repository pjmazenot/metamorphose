<?php

namespace Metamorphose\Data\Validators;

use Metamorphose\Data\DataValidatorInterface;

class IsString implements DataValidatorInterface {

    const NAME = 'type:string';

    public function validate($data): bool {

        return is_string($data);

    }

}
