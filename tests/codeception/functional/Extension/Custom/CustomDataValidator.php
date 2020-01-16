<?php

namespace Tests\Codeception\Functional\Extension\Custom;

use Metamorphose\Data\DataValidator;

class CustomDataValidator extends DataValidator {

    const NAME = 'custom-validator';

    public function validate($data): bool {

        return preg_match('/^[a-zA-Z]+$/', $data);

    }

}