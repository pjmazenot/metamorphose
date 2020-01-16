<?php

namespace Tests\Codeception\Functional\Advanced\Extensions\Custom;

use Metamorphose\Data\DataProcessor;

class CustomDataProcessor extends DataProcessor {

    const NAME = 'custom-processor';

    public function process($data): string {

        if(is_string($data)) {

            return preg_replace('/[0-9]+/', '', $data);

        } else {

            return $data;

        }

    }

}