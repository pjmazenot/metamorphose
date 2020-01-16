<?php

namespace Metamorphose\Data\Processors;

use Metamorphose\Data\DataProcessor;

class CastString extends DataProcessor {

    const NAME = 'cast:string';

    public function process($data) {

        return (string) $data;

    }

}
