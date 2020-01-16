<?php

namespace Metamorphose\Data;

use Metamorphose\Data\Processors\CastString;

class DataProcessorCollection {

    /** @var DataProcessorInterface[] $dataProcessors */
    protected $dataProcessors = [];

    public function __construct() {

        // Register default processors
        $this->registerDataProcessor(new CastString());

    }

    public function registerDataProcessor(DataProcessorInterface $dataProcessor): void {

        $this->dataProcessors[$dataProcessor->getName()] = $dataProcessor;

    }

    public function getDataProcessor(string $name): DataProcessorInterface {

        if(!isset($this->dataProcessors[$name])) {
            throw new \Exception('Data processor "' . $name . '" is not defined');
        }

        return $this->dataProcessors[$name];

    }

}
