<?php

namespace Metamorphose\Data;

interface DataProcessorInterface {

    public function getName(): string;

    public function process($data);

}
