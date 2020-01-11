<?php

namespace Metamorphose\Data;

class DataSet {

    /** @var DataPoint $data */
    protected $data;

    public function __construct(array $data = []) {

        $this->data = new DataPoint($data);

    }

    public function getData(): DataPoint {

        return $this->data;

    }

    public function getCount(): int {

        return $this->data->getCount();

    }

    /**
     * Get a property in a section of the data
     * This supports recursive lookup, e.g: my_section.my_sub_section.my_key
     *
     * @TODO: Key exists?
     *
     * @param string $key Key name
     *
     * @return mixed
     */
    public function get($key) {

        $keyParts = explode('.', $key);

        /** @var DataPoint|DataPoint[]|mixed $section */
        $section = $this->data->getValue();

        $value = null;
        foreach($keyParts as $keyIndex => $keyName) {

            if(!isset($section[$keyName])) {
                break;
            }

            $section = $section[$keyName]->getValue();

            if($keyIndex + 1 >= count($keyParts)) {
                $value = $section;
                break;
            }

        }

        return $value;

    }


    /**
     * Set a property in a section of the data
     * This supports recursive property creation, e.g: my_section.my_sub_section.my_key
     *
     * @param string $key Key name
     * @param mixed $value Value
     *
     * @return mixed
     */
    public function set(string $key, $value): void {

        $keyParts = explode('.', $key);

        /** @var DataPoint|DataPoint[]|mixed $section */
        $section = $this->data;

        foreach($keyParts as $keyIndex => $keyName) {

            $sectionValue = $section->getValue();

            if(!isset($sectionValue[$keyName])) {

                $sectionValue[$keyName] = new DataPoint([]);

            }

            // Update the section
            $section->setValue($sectionValue);

            $section = $sectionValue[$keyName];

            if($keyIndex + 1 >= count($keyParts)) {
                $section->setValue($value);
                break;
            }

        }

    }

}
