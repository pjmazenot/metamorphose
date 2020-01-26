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

    /** @var array $attributes */
    protected $attributes;

    /**
     * DataPoint constructor.
     *
     * @param DataPoint|mixed $value
     * @param array           $attributes
     */
    public function __construct($value, array $attributes = []) {

        if (is_array($value)) {

            $this->value = [];

            foreach ($value as $key => $nextValue) {

                if (is_array($nextValue) && array_key_exists('@attributes', $nextValue) && array_key_exists('value', $nextValue)) {

                    $this->value[$key] = new DataPoint($nextValue['value'], $nextValue['@attributes']);

                } else {

                    $this->value[$key] = new DataPoint($nextValue);

                }

            }

        } else {

            $this->value = $value;

        }

        $this->attributes = $attributes;

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
     * Get the attributes
     *
     * @return array
     */
    public function getAttributes(): array {

        return $this->attributes;

    }

    /**
     * Get an attribute by name
     *
     * @param string $name
     *
     * @return string
     */
    public function getAttribute(string $name): string {

        return isset($this->attributes[$name]) ? (string)$this->attributes[$name] : '';

    }

    /**
     * Set an attribute by name
     *
     * @param string $name
     * @param string $value
     */
    public function setAttribute(string $name, string $value): void {

        $this->attributes[$name] = $value;

    }

    /**
     * Get the count of elements
     *
     * @return int
     */
    public function getCount(): int {

        if (is_array($this->value)) {

            return count($this->value);

        } else {

            return 1;

        }

    }

    /**
     * Get the data as an array
     *
     * @param bool $withAttributes
     *
     * @return array
     */
    public function toArray(bool $withAttributes = false): array {

        if (is_a($this->value, DataPoint::class)) {

            return $withAttributes
                ? [
                    '@attributes' => $this->attributes,
                    'value' => $this->value->toArray(true),
                ]
                : $this->value->toArray();

        } elseif (is_array($this->value) && !empty($this->value)) {

            $valueArray = [];

            foreach ($this->value as $itemKey => $itemValue) {

                /** @var DataPoint|mixed $itemValue */
                if (is_a($itemValue, DataPoint::class)) {

                    // Grap the value from the next object level
                    $nextLevelValue = $itemValue->getValue();

                    if (is_a($nextLevelValue, DataPoint::class)) {

                        $valueArray[$itemKey] = $withAttributes
                            ? [
                                '@attributes' => $itemValue->getAttributes(),
                                'value' => $itemValue->getValue()->toArray(true),
                            ]
                            : $itemValue->getValue()->toArray();

                    } elseif (is_array($nextLevelValue)) {

                        $valueArray[$itemKey] = $withAttributes
                            ? [
                                '@attributes' => $itemValue->getAttributes(),
                                'value' => $itemValue->toArray(true),
                            ]
                            : $itemValue->toArray();

                    } else {

                        $valueArray[$itemKey] = $withAttributes
                            ? [
                                '@attributes' => $itemValue->getAttributes(),
                                'value' => $nextLevelValue,
                            ]
                            : $nextLevelValue;

                    }

                } else {

                    $valueArray[$itemKey] = $withAttributes
                        ? [
                            '@attributes' => $itemValue->getAttributes(),
                            'value' => $itemValue,
                        ]
                        : $itemValue;

                }

            }

            return $valueArray;

        } else {

            return $this->value;

        }

    }

    /**
     * Get the data as an array with attributes
     *
     * @return array
     */
    public function toArrayWithAttributes(): array {

        return $this->toArray(true);

    }

}
