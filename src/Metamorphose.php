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

use Metamorphose\Exceptions\MetamorphoseContractException;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;
use Metamorphose\Exceptions\MetamorphoseValidateException;
use Metamorphose\Morph\MorphEngine;
use Metamorphose\Morph\MorphServices;

/**
 * Class Metamorphose
 * Main class of the Metamorphose package
 *
 * @package Metamorphose
 */
class Metamorphose {

    /** @var MorphEngine $engine */
    protected $engine;

    /**
     * Metamorphose constructor.
     *
     * @param string      $inputContractFilePath
     * @param string|null $outputContractFilePath
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function __construct(string $inputContractFilePath, ?string $outputContractFilePath = null) {

        $this->engine = new MorphEngine($inputContractFilePath, $outputContractFilePath);

    }

    /**
     * Set the source data
     *
     * @param string $sourceType
     * @param string $source
     */
    public function source(string $sourceType, string $source): void {

        $this->engine->load($sourceType, $source);

    }

    /**
     * Customize the services
     *
     * @return MorphServices
     */
    public function customize(): MorphServices {

        return $this->engine->getServices();

    }

    /**
     * Main method of this package. This is when the data is transformed.
     *
     * @throws MetamorphoseContractException
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    public function morph(): void {

        $this->engine->convert();

    }

    /**
     * Get the final data
     *
     * @return string
     * @throws MetamorphoseContractException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function export() {

        return $this->engine->getOutput();

    }

}