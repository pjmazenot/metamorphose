<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Validate;

use Metamorphose\Data\Validate\Validators\Advanced\DateValidator;
use Metamorphose\Data\Validate\Validators\Advanced\EmptyValidator;
use Metamorphose\Data\Validate\Validators\Advanced\EnumValidator;
use Metamorphose\Data\Validate\Validators\Advanced\NotEmptyValidator;
use Metamorphose\Data\Validate\Validators\Advanced\RegexValidator;
use Metamorphose\Data\Validate\Validators\Advanced\StrLengthValidator;
use Metamorphose\Data\Validate\Validators\Operators\BetweenValidator;
use Metamorphose\Data\Validate\Validators\Operators\EqualValidator;
use Metamorphose\Data\Validate\Validators\Operators\GreaterThanOrEqualValidator;
use Metamorphose\Data\Validate\Validators\Operators\GreaterThanValidator;
use Metamorphose\Data\Validate\Validators\Operators\LessThanOrEqualValidator;
use Metamorphose\Data\Validate\Validators\Operators\LessThanValidator;
use Metamorphose\Data\Validate\Validators\Operators\NotEqualValidator;
use Metamorphose\Data\Validate\Validators\Types\ArrayValidator;
use Metamorphose\Data\Validate\Validators\Types\BoolValidator;
use Metamorphose\Data\Validate\Validators\Types\FloatValidator;
use Metamorphose\Data\Validate\Validators\Types\IntValidator;
use Metamorphose\Data\Validate\Validators\Types\NullValidator;
use Metamorphose\Data\Validate\Validators\Types\StringValidator;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class DataValidatorCollection
 *
 * @package Metamorphose\Data\Validate
 */
class ValidatorCollection {

    /** @var ValidatorInterface[] $dataValidators */
    protected $dataValidators = [];

    /**
     * DataValidatorCollection constructor.
     */
    public function __construct() {

        // Register default validators
        // Advanced
        $this->registerDataValidator(new EmptyValidator());
        $this->registerDataValidator(new EnumValidator());
        $this->registerDataValidator(new DateValidator());
        $this->registerDataValidator(new NotEmptyValidator());
        $this->registerDataValidator(new RegexValidator());
        $this->registerDataValidator(new StrLengthValidator());

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

    /**
     * Register a data validator in the collection
     *
     * @param ValidatorInterface $dataValidator
     */
    public function registerDataValidator(ValidatorInterface $dataValidator): void {

        $this->dataValidators[$dataValidator->getName()] = $dataValidator;

    }

    /**
     * Get a data validator from the collection
     *
     * @param string $name
     *
     * @return ValidatorInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataValidator(string $name): ValidatorInterface {

        if(!isset($this->dataValidators[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data validator "' . $name . '" is not defined');

        }

        return $this->dataValidators[$name];

    }

}
