<?php

namespace Metamorphose\Data\Processors;

use Metamorphose\Data\DataProcessorInterface;

class CastString implements DataProcessorInterface {

    const NAME = 'cast:string';

    public function process($data) {

        return (string) $data;

    }

}
