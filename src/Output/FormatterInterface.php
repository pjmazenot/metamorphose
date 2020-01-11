<?php

namespace Metamorphose\Output;

interface FormatterInterface {

    public function format(array $data, array $options = []): string;

}
