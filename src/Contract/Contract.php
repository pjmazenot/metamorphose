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

use Metamorphose\Exceptions\MetamorphoseContractException;

/**
 * Class Contract
 *
 * @package Metamorphose\Contract
 */
class Contract implements ContractInterface {

    const TYPE_COLLECTION = 'collection';
    const TYPE_OBJECT = 'object';

    /** @var array $parsers */
    protected $parsers = [];

    /** @var array $formatters */
    protected $formatters = [];

    /** @var array $options */
    protected $options = [];

    /** @var string $type */
    protected $type;

    /** @var ContractField[] $fields */
    protected $fields = [];

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
     * Get the default parser name
     *
     * @return string
     */
    public function getDefaultParserName(): string {

        return $this->parsers[0];

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

        if(in_array($parserName, $this->parsers)) {

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

        return $this->formatters[0];

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

        if(in_array($formatterName, $this->formatters)) {

            return true;

        }

        throw new MetamorphoseContractException('The formatter "' . $formatterName . '" is not available for this contract');

    }

    /**
     * Get the contract formatters
     *
     * @return array
     */
    public function getFormatters(): array {

        return $this->formatters;

    }

    /**
     * Get the contract options
     *
     * @return array
     */
    public function getOptions(): array {

        return $this->options;

    }

    /**
     * Get the contract type
     *
     * @return string
     */
    public function getType(): string {

        return $this->type;

    }

    /**
     * Get the contract fields
     *
     * @return ContractField[]
     */
    public function getFields(): array {

        return $this->fields;

    }

    /**
     * Parse the contract definition file
     *
     * @param string $filePath
     *
     * @throws MetamorphoseContractException
     */
    protected function parseFile(string $filePath): void {

        $contractData = json_decode(file_get_contents($filePath), true);

        if(isset($contractData['parsers'])) {

            $this->parsers = $contractData['parsers'];

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one parser');

        }

        if(isset($contractData['formatters'])) {

            $this->formatters = $contractData['formatters'];

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one formatter');

        }

        if(isset($contractData['options'])) {

            $this->options = $contractData['options'];

        }

        if(isset($contractData['type'])) {

            if(empty($contractData['type'])) {

                $this->type = self::TYPE_OBJECT;

            } elseif(in_array($contractData['type'], [self::TYPE_COLLECTION, self::TYPE_OBJECT])) {

                $this->type = $contractData['type'];

            } else {
                throw new MetamorphoseContractException('The contract needs to have a valid type defined');
            }
        }

        if(isset($contractData['fields'])) {

            foreach($contractData['fields'] as $fieldData) {

                $this->fields[] = new ContractField($fieldData);

            }

        }

    }

}
