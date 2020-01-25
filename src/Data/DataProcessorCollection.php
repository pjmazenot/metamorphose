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
use Metamorphose\Data\Processors\Strings\ConcatProcessor;
use Metamorphose\Data\Processors\Strings\ExplodeProcessor;
use Metamorphose\Data\Processors\Strings\HashProcessor;
use Metamorphose\Data\Processors\Strings\HtmlentitiesProcessor;
use Metamorphose\Data\Processors\Strings\ReplaceProcessor;
use Metamorphose\Data\Processors\Strings\StripslashesProcessor;
use Metamorphose\Data\Processors\Strings\StripTagProcessor;
use Metamorphose\Data\Processors\Strings\WrapperProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToBoolProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToFloatProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToIntProcessor;
use Metamorphose\Data\Processors\TypeCasting\ToStringProcessor;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class DataProcessorCollection
 *
 * @package Metamorphose\Data
 */
class DataProcessorCollection {

    /** @var DataProcessorInterface[] $dataProcessors */
    protected $dataProcessors = [];

    /**
     * DataProcessorCollection constructor.
     */
    public function __construct() {

        // Register default processors
        // Arrays
        $this->registerDataProcessor(new ImplodeProcessor());
        $this->registerDataProcessor(new UniqueProcessor());

        // Json
        $this->registerDataProcessor(new JsonDecodeProcessor());
        $this->registerDataProcessor(new JsonEncodeProcessor());

        // Strings
        $this->registerDataProcessor(new ConcatProcessor());
        $this->registerDataProcessor(new ExplodeProcessor());
        $this->registerDataProcessor(new HashProcessor());
        $this->registerDataProcessor(new HtmlentitiesProcessor());
        $this->registerDataProcessor(new ReplaceProcessor());
        $this->registerDataProcessor(new StripslashesProcessor());
        $this->registerDataProcessor(new StripTagProcessor());
        $this->registerDataProcessor(new WrapperProcessor());

        // TypeCasting
        $this->registerDataProcessor(new ToBoolProcessor());
        $this->registerDataProcessor(new ToFloatProcessor());
        $this->registerDataProcessor(new ToIntProcessor());
        $this->registerDataProcessor(new ToStringProcessor());

    }

    /**
     * Register a data processor in the collection
     *
     * @param DataProcessorInterface $dataProcessor
     */
    public function registerDataProcessor(DataProcessorInterface $dataProcessor): void {

        $this->dataProcessors[$dataProcessor->getName()] = $dataProcessor;

    }

    /**
     * Get a data processor from the collection
     *
     * @param string $name
     *
     * @return DataProcessorInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataProcessor(string $name): DataProcessorInterface {

        if(!isset($this->dataProcessors[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data processor "' . $name . '" is not defined');

        }

        return $this->dataProcessors[$name];

    }

}
