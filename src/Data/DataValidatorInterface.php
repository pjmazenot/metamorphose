<?php

namespace Metamorphose\Data;

interface DataValidatorInterface {

    public function validate($data): bool;

}
