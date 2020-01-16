<?php

namespace Metamorphose\Output;

interface FormatterInterface {

    public function getName(): string;

    public function format(array $data, array $options = []): string;

}
