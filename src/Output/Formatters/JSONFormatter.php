<?php

namespace Metamorphose\Output\Formatters;

use Metamorphose\Output\Formatter;

class JSONFormatter extends Formatter {

    const NAME = 'json';
    const FORMAT = 'application/json';

    public function format(array $data, array $options = []): string {

        return json_encode($data);

    }

}
