<?php

namespace Metamorphose\Data;

use Metamorphose\Data\Validators\IsString;

class DataValidatorCollection {

    /** @var DataValidatorInterface[] $dataValidators */
    protected $dataValidators = [];

    public function __construct() {

        // Register default validators
        $this->registerDataValidator(new IsString());

    }

    public function registerDataValidator(DataValidatorInterface $dataValidator): void {

        $this->dataValidators[$dataValidator->getName()] = $dataValidator;

    }

    public function getDataValidator(string $name): DataValidatorInterface {

        if(!isset($this->dataValidators[$name])) {
            throw new \Exception('Data processor "' . $name . '" is not defined');
        }

        return $this->dataValidators[$name];

    }

}
