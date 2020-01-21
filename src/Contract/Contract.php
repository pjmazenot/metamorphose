<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Contract;

use Metamorphose\Contract\Definitions\ContractDestinationDefinition;
use Metamorphose\Contract\Definitions\ContractSourceDefinition;
use Metamorphose\Exceptions\MetamorphoseContractException;

/**
 * Class Contract
 *
 * @package Metamorphose\Contract
 */
class Contract implements ContractInterface {

    /** @var array $sources */
    protected $sources = [];

    /** @var array $destinations */
    protected $destinations = [];

    /**
     * Contract constructor.
     *
     * @param string $filePath
     *
     * @throws MetamorphoseContractException
     */
    public function __construct(string $filePath) {

        $this->parseFile($filePath);

    }

    /**
     * Get the contract sources
     *
     * @return ContractSourceDefinition[]
     */
    public function getSources(): array {

        return $this->sources;

    }

    /**
     * Get the contract destinations
     *
     * @return ContractDestinationDefinition[]
     */
    public function getDestinations(): array {

        return $this->destinations;

    }

    /**
     * Parse the contract definition file
     *
     * @param string $filePath
     *
     * @throws MetamorphoseContractException
     */
    protected function parseFile(string $filePath): void {

        // Get the contract definition
        $contractDefinition = json_decode(file_get_contents($filePath), true);

        // Inspect the contract definition for errors
        $contractInspector = new ContractInspector();
        $contractInspector->inspect($contractDefinition);

        // Set the source definitions
        foreach($contractDefinition['sources'] as $sourceDefinitionData) {

            $sourceDefinition = new ContractSourceDefinition($sourceDefinitionData);
            $this->sources[$sourceDefinition->getName()] = $sourceDefinition;

        }

        // Set the destination definitions
        foreach($contractDefinition['destinations'] as $destinationDefinitionData) {

            $destinationDefinition = new ContractDestinationDefinition($destinationDefinitionData);
            $this->destinations[$destinationDefinition->getName()] = $destinationDefinition;

        }

    }











    /**
     * Get the default parser name
     *
     * @return string
     */
    public function getDefaultParserName(): string {

        return $this->sources[0];

    }

    /**
     * Check if a parser is defined
     *
     * @param string $parserName
     *
     * @return bool
     * @throws MetamorphoseContractException
     */
    public function isParserAuthorizedOrThrow(string $parserName): bool {

        if(in_array($parserName, $this->sources)) {

            return true;

        }

        throw new MetamorphoseContractException('The parser "' . $parserName . '" is not available for this contract');

    }

    /**
     * Get the default formatter name
     *
     * @return string
     */
    public function getDefaultFormatterName(): string {

        return $this->destinations[0];

    }

    /**
     * Check if a formatter is defined
     *
     * @param string $formatterName
     *
     * @return bool
     * @throws MetamorphoseContractException
     */
    public function isFormatterAuthorizedOrThrow(string $formatterName): bool {

        if(in_array($formatterName, $this->destinations)) {

            return true;

        }

        throw new MetamorphoseContractException('The formatter "' . $formatterName . '" is not available for this contract');

    }

}
