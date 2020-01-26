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
use Metamorphose\Core\Engine;
use Metamorphose\Core\ServiceContainer;

/**
 * Class Metamorphose
 * Main class of the Metamorphose package
 *
 * @package Metamorphose
 */
class Metamorphose {

    /** @var Engine $engine */
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

        $this->engine = new Engine($inputContractFilePath, $outputContractFilePath);

    }

    /**
     * Get or customize the services
     *
     * @return ServiceContainer
     */
    public function services(): ServiceContainer {

        return $this->engine->getServices();

    }

    /**
     * Extract the data from the source(s)
     *
     * @param array $sourcesDynamicOptions
     *
     * @throws MetamorphoseDataSourceException
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function extract(array $sourcesDynamicOptions = []): void {

        $this->engine->extract($sourcesDynamicOptions);

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
     * Load the final data in the destination(s)
     *
     * @param array $destinationsDynamicOptions
     *
     * @return array
     * @throws MetamorphoseDataDestinationException
     * @throws MetamorphoseException
     * @throws MetamorphoseFormatterException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function load(array $destinationsDynamicOptions = []): array {

        return $this->engine->load($destinationsDynamicOptions);

    }

}