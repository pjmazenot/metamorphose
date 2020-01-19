<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose;

use Metamorphose\Contract\Contract;
use Metamorphose\Contract\ContractValidator;
use Metamorphose\Data\DataProcessorCollection;
use Metamorphose\Data\DataProcessorInterface;
use Metamorphose\Data\DataSet;
use Metamorphose\Data\DataValidatorCollection;
use Metamorphose\Data\DataValidatorInterface;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Exceptions\MetamorphoseValidateException;
use Metamorphose\Input\ParserCollection;
use Metamorphose\Input\ParserInterface;
use Metamorphose\Morph\MorphEngine;
use Metamorphose\Morph\MorphServices;
use Metamorphose\Output\FormatterCollection;
use Metamorphose\Output\FormatterInterface;

class Metamorphose {

    /** @var MorphEngine $engine */
    protected $engine;

    public function __construct(string $inputContractFilePath, string $outputContractFilePath = null) {

        $this->engine = new MorphEngine($inputContractFilePath, $outputContractFilePath);

    }

    public function source(string $sourceType, string $source): void {

        $this->engine->load($sourceType, $source);

    }

    public function customize(): MorphServices {

        return $this->engine->getServices();

    }

    public function morph(): void {

        $this->engine->convert();

    }

    public function export() {

        return $this->engine->getOutput();

    }

}