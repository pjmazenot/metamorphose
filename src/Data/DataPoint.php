<?php

namespace Metamorphose\Data;

class DataPoint {

    /** @var DataPoint|mixed $value */
    protected $value;

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
     * @return DataPoint|mixed
     */
    public function getValue() {

        return $this->value;

    }

    /**
     * @param DataPoint|mixed $value
     */
    public function setValue($value): void {

        $this->value = $value;

    }

    public function getCount(): int {

        if(is_array($this->value)) {

            return count($this->value);

        } else {

            return 1;

        }

    }

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
