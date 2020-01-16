<?php

namespace Tests\Codeception\Functional\Extension\Custom;

use Metamorphose\Output\Formatter;

class CustomFormatter extends Formatter {

    const NAME = 'custom-formatter';

    public function format(array $data, array $options = []): string {

        $finalData = [];
        foreach($data as $property => $value) {

            $finalData[] = $property . ':' . $value;

        }

        return implode('|', $finalData);

    }

}