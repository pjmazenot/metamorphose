<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Transform;

use Metamorphose\Data\Transform\Processors\Arrays\ImplodeProcessor;
use Metamorphose\Data\Transform\Processors\Arrays\UniqueProcessor;
use Metamorphose\Data\Transform\Processors\Base\DefaultProcessor;
use Metamorphose\Data\Transform\Processors\Base\ValueProcessor;
use Metamorphose\Data\Transform\Processors\Json\JsonDecodeProcessor;
use Metamorphose\Data\Transform\Processors\Json\JsonEncodeProcessor;
use Metamorphose\Data\Transform\Processors\Strings\ConcatProcessor;
use Metamorphose\Data\Transform\Processors\Strings\ExplodeProcessor;
use Metamorphose\Data\Transform\Processors\Strings\HashProcessor;
use Metamorphose\Data\Transform\Processors\Strings\HtmlentitiesProcessor;
use Metamorphose\Data\Transform\Processors\Strings\ReplaceProcessor;
use Metamorphose\Data\Transform\Processors\Strings\StripslashesProcessor;
use Metamorphose\Data\Transform\Processors\Strings\StripTagProcessor;
use Metamorphose\Data\Transform\Processors\Strings\WrapperProcessor;
use Metamorphose\Data\Transform\Processors\TypeCasting\ToBoolProcessor;
use Metamorphose\Data\Transform\Processors\TypeCasting\ToFloatProcessor;
use Metamorphose\Data\Transform\Processors\TypeCasting\ToIntProcessor;
use Metamorphose\Data\Transform\Processors\TypeCasting\ToStringProcessor;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class DataProcessorCollection
 *
 * @package Metamorphose\Data\Transform
 */
class ProcessorCollection {

    /** @var ProcessorInterface[] $dataProcessors */
    protected $dataProcessors = [];

    /**
     * DataProcessorCollection constructor.
     */
    public function __construct() {

        // Register default processors
        // Arrays
        $this->registerDataProcessor(new ImplodeProcessor());
        $this->registerDataProcessor(new UniqueProcessor());

        // Base
        $this->registerDataProcessor(new DefaultProcessor());
        $this->registerDataProcessor(new ValueProcessor());

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
     * @param ProcessorInterface $dataProcessor
     */
    public function registerDataProcessor(ProcessorInterface $dataProcessor): void {

        $this->dataProcessors[$dataProcessor->getName()] = $dataProcessor;

    }

    /**
     * Get a data processor from the collection
     *
     * @param string $name
     *
     * @return ProcessorInterface
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getDataProcessor(string $name): ProcessorInterface {

        if(!isset($this->dataProcessors[$name])) {

            throw new MetamorphoseUndefinedServiceException('Data processor "' . $name . '" is not defined');

        }

        return $this->dataProcessors[$name];

    }

}
