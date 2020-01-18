<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data;

use Metamorphose\Data\Processors\Arrays\ImplodeProcessor;
use Metamorphose\Data\Processors\Arrays\UniqueProcessor;
use Metamorphose\Data\Processors\Json\JsonDecodeProcessor;
use Metamorphose\Data\Processors\Json\JsonEncodeProcessor;
use Metamorphose\Data\Processors\Strings\ExplodeProcessor;
use Metamorphose\Data\Processors\Strings\HashProcessor;
use Metamorphose\Data\Processors\Strings\HtmlentitiesProcessor;
use Metamorphose\Data\Processors\Strings\ReplaceProcessor;
use Metamorphose\Data\Processors\Strings\StripslashesProcessor;
use Metamorphose\Data\Processors\Strings\StripTagProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToBoolProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToFloatProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToIntProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToStringProcessor;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

class DataProcessorCollection {

    /** @var DataProcessorInterface[] $dataProcessors */
    protected $dataProcessors = [];

    public function __construct() {

        // Register default processors
        // Arrays
        $this->registerDataProcessor(new ImplodeProcessor());
        $this->registerDataProcessor(new UniqueProcessor());

        // Json
        $this->registerDataProcessor(new JsonDecodeProcessor());
        $this->registerDataProcessor(new JsonEncodeProcessor());

        // Strings
        $this->registerDataProcessor(new ExplodeProcessor());
        $this->registerDataProcessor(new HashProcessor());
        $this->registerDataProcessor(new HtmlentitiesProcessor());
        $this->registerDataProcessor(new ReplaceProcessor());
        $this->registerDataProcessor(new StripslashesProcessor());
        $this->registerDataProcessor(new StripTagProcessor());

        // TypeCasting
        $this->registerDataProcessor(new ToBoolProcessor());
        $this->registerDataProcessor(new ToFloatProcessor());
        $this->registerDataProcessor(new ToIntProcessor());
        $this->registerDataProcessor(new ToStringProcessor());

    }

    public function registerDataProcessor(DataProcessorInterface $dataProcessor): void {

        $this->dataProcessors[$dataProcessor->getName()] = $dataProcessor;

    }

    public function getDataProcessor(string $name): DataProcessorInterface {

        if(!isset($this->dataProcessors[$name])) {
            throw new MetamorphoseUndefinedServiceException('Data processor "' . $name . '" is not defined');
        }

        return $this->dataProcessors[$name];

    }

}
