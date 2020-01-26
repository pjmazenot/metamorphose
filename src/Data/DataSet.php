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
 * Class DataSet
 *
 * @package Metamorphose\Data
 */
class DataSet {

    /** @var DataPoint $data */
    protected $data;

    /**
     * DataSet constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = []) {

        if (array_key_exists('@attribute', $data) && array_key_exists('value', $data)) {

            $this->data = new DataPoint($data['value'], $data['@attribute']);

        } else {

            $this->data = new DataPoint($data);

        }

    }

    /**
     * Get the data
     *
     * @return DataPoint
     */
    public function getData(): DataPoint {

        return $this->data;

    }

    /**
     * Get the count of elements
     *
     * @return int
     */
    public function getCount(): int {

        return $this->data->getCount();

    }

    /**
     * Get a property in a section of the data
     * This supports recursive lookup, e.g: my_section.my_sub_section.my_key
     *
     * @param string $key Key name
     *
     * @return mixed
     */
    public function get($key) {

        // Get the key parts
        $keyParts = explode('.', $key);

        /** @var DataPoint|DataPoint[]|mixed $section */
        $section = $this->data->getValue();

        $value = null;
        foreach ($keyParts as $keyIndex => $keyName) {

            // If the key part contains an attribute name we grab this name an update the current key name
            if (strpos($keyName, '@')) {

                $keyNameParts = explode('@', $keyName);
                $keyName = $keyNameParts[0];
                $attributeName = $keyNameParts[1];

            }

            // If the next section is not set we are trying to access an undefined value
            if (!isset($section[$keyName])) {
                break;
            }

            if (isset($attributeName)) {

                // Get the attribute and automatically return the value (there should never be a key name following the attribute)
                $value = $section[$keyName]->getAttribute($attributeName);
                break;

            } else {

                // Get the value
                $section = $section[$keyName]->getValue();

                if ($keyIndex + 1 >= count($keyParts)) {

                    // If the key is the last part return the current value
                    $value = $section;
                    break;

                }

            }

        }

        return $value;

    }


    /**
     * Set a property in a section of the data
     * This supports recursive property creation, e.g: my_section.my_sub_section.my_key
     *
     * @param string $key   Key name
     * @param mixed  $value Value
     *
     * @return mixed
     */
    public function set(string $key, $value): void {

        $keyParts = explode('.', $key);

        /** @var DataPoint|DataPoint[]|mixed $section */
        $section = $this->data;

        foreach ($keyParts as $keyIndex => $keyName) {

            // If the key part contains an attribute name we grab this name an update the current key name
            if (strpos($keyName, '@')) {

                $keyNameParts = explode('@', $keyName);
                $keyName = $keyNameParts[0];
                $attributeName = $keyNameParts[1];

            }

            $sectionValue = $section->getValue();

            if (!isset($sectionValue[$keyName])) {

                $sectionValue[$keyName] = new DataPoint([]);

            }

            // Update the section
            $section->setValue($sectionValue);

            $section = $sectionValue[$keyName];

            if (isset($attributeName)) {

                // Set the attribute
                $section->setAttribute($attributeName, $value);
                break;

            } else {

                if ($keyIndex + 1 >= count($keyParts)) {
                    $section->setValue($value);
                    break;
                }

            }

        }

    }

}
