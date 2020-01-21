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
use Metamorphose\Exceptions\MetamorphoseDataDestinationException;
use Metamorphose\Exceptions\MetamorphoseDataSourceException;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Exceptions\MetamorphoseFormatterException;
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
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseDataSourceException
     */
    public function __construct(string $inputContractFilePath, ?string $outputContractFilePath = null) {

        $this->engine = new MorphEngine($inputContractFilePath, $outputContractFilePath);

    }

    /**
     * Get or customize the services
     *
     * @return MorphServices
     */
    public function services(): MorphServices {

        return $this->engine->getServices();

    }

    /**
     * Extract the data from the source
     *
     * @param array $sources
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function extract(array $sources = []): void {

        $this->engine->extract($sources);

    }

    /**
     * Transform the data
     *
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     * @throws MetamorphoseValidateException
     */
    public function transform(): void {

        $this->engine->transform();

    }

    /**
     * Load the final data
     *
     * @param array $destinations
     *
     * @return array
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseException
     * @throws MetamorphoseFormatterException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function load(array $destinations = []): array {

        return $this->engine->load($destinations);

    }

}