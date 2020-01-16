<?php

namespace Metamorphose\Data\Processors;

use Metamorphose\Data\DataProcessor;

class JsonEncode extends DataProcessor {

    const NAME = 'json_encode';

    public function process($data, array $params = []) {

        return json_encode($data);

    }

}
