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
 * Class ContractInspector
 *
 * @package Metamorphose\Contract
 */
class ContractInspector {

    /**
     * Inspect a contract definition
     *
     * @TODO: source/destination name conflict
     * @TODO: Force at least one processor value in apply?
     *
     * @param array $contractDefinition
     *
     * @throws MetamorphoseContractException
     */
    public function inspect(array $contractDefinition) {

        if (!empty($contractDefinition['sources'])) {

            foreach ($contractDefinition['sources'] as $sourceDefinition) {

                $this->inspectSourceDefinition($sourceDefinition);

            }

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one source');

        }

        if (!empty($contractDefinition['destinations'])) {

            foreach ($contractDefinition['destinations'] as $destinationDefinition) {

                $this->inspectDestinationDefinition($destinationDefinition);

            }

        } else {

            throw new MetamorphoseContractException('The contract needs to have at least one destination');

        }

    }

    /**
     * Inspect a source definition
     *
     * @param array $sourceDefinition
     *
     * @throws MetamorphoseContractException
     */
    protected function inspectSourceDefinition(array $sourceDefinition) {

        if (!isset($sourceDefinition['name'])) {

            throw new MetamorphoseContractException('The source definition needs to have a name');

        }

        if (!isset($sourceDefinition['type'])) {

            throw new MetamorphoseContractException('The source definition needs to have a type');

        }

        if (!empty($sourceDefinition['fields'])) {

            foreach ($sourceDefinition['fields'] as $fieldDefinition) {

                $this->inspectFieldDefinition($fieldDefinition, 'source');

            }

        }

    }

    /**
     * Inspect a destination definition
     *
     * @param array $sourceDefinition
     *
     * @throws MetamorphoseContractException
     */
    protected function inspectDestinationDefinition(array $sourceDefinition) {

        if (!isset($sourceDefinition['name'])) {

            throw new MetamorphoseContractException('The destination definition needs to have a name');

        }

        if (!isset($sourceDefinition['type'])) {

            throw new MetamorphoseContractException('The destination definition needs to have a type');

        }

        if (!empty($sourceDefinition['fields'])) {

            foreach ($sourceDefinition['fields'] as $fieldDefinition) {

                $this->inspectFieldDefinition($fieldDefinition, 'destination');

            }

        } else {

            throw new MetamorphoseContractException('The destination field definition needs to have at least one field');

        }

    }

    /**
     * Inspect a field definition for a source or a destination
     *
     * @param array  $fieldDefinition
     * @param string $type
     *
     * @throws MetamorphoseContractException
     */
    protected function inspectFieldDefinition(array $fieldDefinition, string $type) {

        if (!isset($fieldDefinition['name'])) {

            throw new MetamorphoseContractException('The ' . $type . ' field definition needs to have a name');

        }

        if (!empty($fieldDefinition['apply'])) {

            $validDestinationApplyCount = 0;
            foreach ($fieldDefinition['apply'] as $fieldApplyDefinition) {

                $this->inspectApplyDefinition($fieldApplyDefinition, $type);

                if (in_array($fieldApplyDefinition['type'], ['value', 'processor'])) {

                    $validDestinationApplyCount++;

                }

            }

        }

        if (!empty($fieldDefinition['attributes'])) {

            foreach ($fieldDefinition['attributes'] as $attributeDefinition) {

                $this->inspectAttributeDefinition($attributeDefinition, $fieldDefinition['name'], $type);

            }

        }

        if ($type === 'destination' && (empty($fieldDefinition['apply']) || empty($validDestinationApplyCount))) {

            throw new MetamorphoseContractException('The ' . $type . ' field definition needs to have at least one valid apply');

        }

    }

    /**
     * Inspect an attribute definition for a source or a destination
     *
     * @param array  $attributeDefinition
     * @param string $fieldName
     * @param string $type
     *
     * @throws MetamorphoseContractException
     */
    protected function inspectAttributeDefinition(array $attributeDefinition, string $fieldName, string $type) {

        if (!isset($attributeDefinition['name'])) {

            throw new MetamorphoseContractException('The ' . $type . ' field ' . $fieldName . ' attribute definition needs to have a name');

        }

        if (!empty($attributeDefinition['apply'])) {

            $validDestinationApplyCount = 0;
            foreach ($attributeDefinition['apply'] as $attributeApplyDefinition) {

                $this->inspectApplyDefinition($attributeApplyDefinition, $type);

                if (in_array($attributeApplyDefinition['type'], ['value', 'processor'])) {

                    $validDestinationApplyCount++;

                }

            }

        }

        if ($type === 'destination' && (empty($attributeDefinition['apply']) || empty($validDestinationApplyCount))) {

            throw new MetamorphoseContractException('The ' . $type . ' field definition needs to have at least one valid apply');

        }

    }

    /**
     * Inspect an apply definition for a field
     *
     * @param array  $fieldApplyDefinition
     * @param string $type
     *
     * @throws MetamorphoseContractException
     */
    protected function inspectApplyDefinition(array $fieldApplyDefinition, string $type) {

        if (!isset($fieldApplyDefinition['type']) || !in_array($fieldApplyDefinition['type'], ['value', 'processor', 'validator'])) {

            throw new MetamorphoseContractException('The ' . $type . ' field definition needs to have at least one field');

        }

        if ($type === 'source' && $fieldApplyDefinition['type'] === 'value') {

            throw new MetamorphoseContractException('The ' . $type . ' field apply field is not supported for a source');

        }

        if ($type === 'destination' && in_array($fieldApplyDefinition['type'], ['processor', 'validator']) && empty($fieldApplyDefinition['name'])) {

            throw new MetamorphoseContractException('The ' . $type . ' field definition needs to have a name');

        }

        if (!empty($fieldApplyDefinition['args'])) {

            if (!is_array($fieldApplyDefinition['args'])) {

                throw new MetamorphoseContractException('The ' . $type . ' args parameter should be an array');

            } else {

                foreach ($fieldApplyDefinition['args'] as $arg) {

                    if ($type === 'source' && strpos($arg, '$ref:') === 0) {

                        throw new MetamorphoseContractException('Arguments can\'t be references in a source definition');

                    }

                }

            }

        }

    }

}
