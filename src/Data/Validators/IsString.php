<?php

namespace Metamorphose\Data\Validators;

use Metamorphose\Data\DataValidator;

class IsString extends DataValidator {

    const NAME = 'type:string';

    public function validate($data): bool {

        return is_string($data);

    }

}
