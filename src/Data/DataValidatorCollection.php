<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data;

use Metamorphose\Data\Validators\Advanced\DateValidator;
use Metamorphose\Data\Validators\Advanced\EmptyValidator;
use Metamorphose\Data\Validators\Advanced\EnumValidator;
use Metamorphose\Data\Validators\Advanced\RegexValidator;
use Metamorphose\Data\Validators\Operators\BetweenValidator;
use Metamorphose\Data\Validators\Operators\EqualValidator;
use Metamorphose\Data\Validators\Operators\GreaterThanOrEqualValidator;
use Metamorphose\Data\Validators\Operators\GreaterThanValidator;
use Metamorphose\Data\Validators\Operators\LessThanOrEqualValidator;
use Metamorphose\Data\Validators\Operators\LessThanValidator;
use Metamorphose\Data\Validators\Operators\NotEqualValidator;
use Metamorphose\Data\Validators\Types\ArrayValidator;
use Metamorphose\Data\Validators\Types\BoolValidator;
use Metamorphose\Data\Validators\Types\FloatValidator;
use Metamorphose\Data\Validators\Types\IntValidator;
use Metamorphose\Data\Validators\Types\NullValidator;
use Metamorphose\Data\Validators\Types\StringValidator;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

class DataValidatorCollection {

    /** @var DataValidatorInterface[] $dataValidators */
    protected $dataValidators = [];

    public function __construct() {

        // Register default validators
        // Advanced
        $this->registerDataValidator(new EmptyValidator());
        $this->registerDataValidator(new EnumValidator());
        $this->registerDataValidator(new DateValidator());
        $this->registerDataValidator(new RegexValidator());

        // Operators
        $this->registerDataValidator(new BetweenValidator());
        $this->registerDataValidator(new EqualValidator());
        $this->registerDataValidator(new GreaterThanOrEqualValidator());
        $this->registerDataValidator(new GreaterThanValidator());
        $this->registerDataValidator(new LessThanOrEqualValidator());
        $this->registerDataValidator(new LessThanValidator());
        $this->registerDataValidator(new NotEqualValidator());

        // Types
        $this->registerDataValidator(new ArrayValidator());
        $this->registerDataValidator(new BoolValidator());
        $this->registerDataValidator(new FloatValidator());
        $this->registerDataValidator(new IntValidator());
        $this->registerDataValidator(new NullValidator());
        $this->registerDataValidator(new StringValidator());

    }

    public function registerDataValidator(DataValidatorInterface $dataValidator): void {

        $this->dataValidators[$dataValidator->getName()] = $dataValidator;

    }

    public function getDataValidator(string $name): DataValidatorInterface {

        if(!isset($this->dataValidators[$name])) {
            throw new MetamorphoseUndefinedServiceException('Data processor "' . $name . '" is not defined');
        }

        return $this->dataValidators[$name];

    }

}
