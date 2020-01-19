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

/**
 * Class DataPoint
 *
 * @package Metamorphose\Data
 */
class DataPoint {

    /** @var DataPoint|mixed $value */
    protected $value;

    /**
     * DataPoint constructor.
     *
     * @param DataPoint|mixed $value
     */
    public function __construct($value) {

        if(is_array($value)) {

            $this->value = [];

            foreach($value as $key => $nextValue) {

                $this->value[$key] = new DataPoint($nextValue);

            }

        } else {

            $this->value = $value;

        }

    }

    /**
     * Get the value
     *
     * @return DataPoint|mixed
     */
    public function getValue() {

        return $this->value;

    }

    /**
     * Set the value
     *
     * @param DataPoint|mixed $value
     */
    public function setValue($value): void {

        $this->value = $value;

    }

    /**
     * Get the count of elements
     *
     * @return int
     */
    public function getCount(): int {

        if(is_array($this->value)) {

            return count($this->value);

        } else {

            return 1;

        }

    }

    /**
     * Get the data as an array
     *
     * @return array
     */
    public function toArray(): array {

        if(is_a($this->value, self::class)) {

            return $this->value->toArray();

        } elseif(is_array($this->value) && !empty($this->value)) {

            $valueArray = [];

            foreach($this->value as $key => $nextValue) {

                /** @var DataPoint|mixed $nextValue */
                if(is_a($nextValue, self::class)) {

                    // @TODO: Do better - lol
                    $nextValueValue = $nextValue->getValue();
                    if(is_array($nextValueValue)) {
                        $valueArray[$key] = $nextValue->toArray();
                    } else {
                        $valueArray[$key] = $nextValueValue;
                    }
                } else {
                    $valueArray[$key] = $nextValue;
                }

            }

            return $valueArray;

        } else {

            return $this->value;

        }

    }

}
