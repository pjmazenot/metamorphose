<?php

namespace Metamorphose\Data;

interface DataValidatorInterface {

    public function getName(): string;

    public function validate($data): bool;

}
