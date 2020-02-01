<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data\Find;

use Metamorphose\Data\DataSetCollection;
use Metamorphose\Exceptions\MetamorphoseException;
use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class ReferenceLocator
 *
 * @package Metamorphose\Core\Engine
 */
class ReferenceLocator {

    const REF_START = '$ref:';

    /** @var bool $isRef */
    protected $isRef;

    /** @var string $dataSetName */
    protected $dataSetName;

    /** @var string $ref */
    protected $ref;

    /** @var array $refCollectionParts This holds the parts of the key to be able to generate the next key */
    protected $refCollectionParts;

    /** @var array $indexes */
    protected $indexes = [];

    /** @var int $globalIndex */
    protected $globalIndex;

    /** @var array $counts */
    protected $counts = [];

    /** @var Reference $lastReference */
    protected $lastReference;

    /**
     * ReferenceLocator constructor.
     *
     * @param mixed $ref
     */
    public function __construct($ref) {

        $this->isRef = is_string($ref) && strpos($ref, self::REF_START) !== false ? true : false;

        if ($this->isRef) {

            $ref = str_replace(self::REF_START, '', $ref);

            if (
                strpos($ref, '[n]') > 0
                && strpos($ref, '[n]') < strpos($ref, '.')
            ) {

                $refParts = explode('[n]', $ref);
                $this->dataSetName = array_shift($refParts);
                $this->ref = '[n]' . implode('[n]', $refParts);

            } else {

                $refParts = explode('.', $ref);
                $this->dataSetName = array_shift($refParts);
                $this->ref = implode('.', $refParts);

            }

            $this->refCollectionParts = explode('[n]', $this->ref);

        }

    }

    /**
     * Get the ref string
     *
     * @return string
     */
    public function getRef(): string {

        return '$ref:' . $this->ref;

    }

    /**
     * Check if the ref string is a reference
     *
     * @return bool
     */
    public function isReference(): bool {

        return $this->isRef;

    }

    /**
     * Check if there is no next reference
     *
     * @return bool
     */
    public function isDone(): bool {

        return $this->lastReference->isLast();

    }

    /**
     * Get the next reference from a dataset
     *
     * @param DataSetCollection $dataSetCollection
     *
     * @return Reference|null
     * @throws MetamorphoseException
     * @throws MetamorphoseUndefinedServiceException
     */
    public function getNextReference(DataSetCollection $dataSetCollection): Reference {

        if (!$this->isRef) {

            throw new MetamorphoseException('Can\'t process - not a reference');

        }

        // Return null if we are trying to get a reference after the last one has been returned
        if (isset($this->lastReference) && $this->lastReference->isLast()) {

            return new Reference(
                $this->ref,
                null,
                true,
                array_merge($this->indexes, ['g' => $this->globalIndex])
            );

        }

        // Get the number of nested collections by counting occurrences of [n].
        $collectionLevels = substr_count($this->ref, '[n].');

        if ($collectionLevels === 0) {

            // This is a direct reference so we can return it without further processing
            $this->lastReference = new Reference(
                $this->ref,
                $dataSetCollection->getDataSet($this->dataSetName)->get($this->ref),
                true
            );

        } else {

            $this->lastReference = $this->getNextReferenceEngine($dataSetCollection);

        }

        return $this->lastReference;

    }

    /**
     * Should never be called if we have already reached the last reference
     *
     * @param DataSetCollection $dataSetCollection
     *
     * @return Reference|null
     * @throws MetamorphoseUndefinedServiceException
     */
    protected function getNextReferenceEngine(DataSetCollection $dataSetCollection): ?Reference {

        $maxCollectionLevel = count($this->refCollectionParts) - 1;

        // Increment the last level index by 1
        if (isset($this->indexes[$maxCollectionLevel])) {

            $this->indexes[$maxCollectionLevel]++;

        }

        // Increment the global index by 1 or init it
        if (isset($this->globalIndex)) {

            $this->globalIndex++;

        } else {

            $this->globalIndex = 0;

        }

        // Update the index hierarchy if we have reached the max index in the collection
        for ($i = $maxCollectionLevel; $i > 0; $i--) {

            if (!isset($this->indexes[$i])) {

                $this->indexes[$i] = 0;

            } elseif (
                isset($this->counts[$i])
                && $this->indexes[$i] > $this->counts[$i] - 1
            ) {

                // Setting the level count to null mean that it will have to be recalculated
                $this->counts[$i] = null;

                // Set the current level to 0 and increment the n-1 level index
                $this->indexes[$i] = 0;
                $this->indexes[$i - 1]++;

            } else {

                break;

            }

        }

        // Init missing counts
        $valueKey = '';
        $collectionKey = '';
        foreach ($this->refCollectionParts as $index => $refCollectionPart) {

            $collectionLevel = $index + 1;

            // Skip last level as it's not a collection - right after generating the full key
            if ($collectionLevel > $maxCollectionLevel) {

                $valueKey .= (!empty($valueKey) ? '.' : '') . $this->indexes[$collectionLevel - 1] . $refCollectionPart;
                break;

            }

            // Progressively build the first collection of each level to get the counts
            // The first part of the ref will be an empty string empty if the first collection is at the root level
            $collectionKey .= ($collectionLevel > 1 ? $this->indexes[$collectionLevel - 1] : '') . $refCollectionPart;
            $valueKey .= ($collectionLevel > 1 ? '.' . $this->indexes[$collectionLevel - 1] : '') . $refCollectionPart;

            if (!isset($this->counts[$collectionLevel])) {

                // @TODO: Throw if is not collection "Trying to access static value as a collection"?
                if (empty($collectionKey)) {
                    // Exception if the collection is at the first level
                    $this->counts[$collectionLevel] = $dataSetCollection->getDataSet($this->dataSetName)->getCount();
                } else {
                    $this->counts[$collectionLevel] = count($dataSetCollection->getDataSet($this->dataSetName)->get($collectionKey));
                }

            }

        }

        // Predict if the current iteration is the end of the process
        $isLastReference = $this->predictLast();

        // Create and return the reference
        return new Reference(
            $valueKey,
            $dataSetCollection->getDataSet($this->dataSetName)->get($valueKey),
            $isLastReference,
            array_merge($this->indexes, ['g' => $this->globalIndex])
        );

    }

    /**
     * Predict if the current reference is the last
     *
     * @return bool
     */
    protected function predictLast(): bool {

        $maxLevel = count($this->refCollectionParts) - 1;
        $indexes = $this->indexes;
        $counts = $this->counts;

        // Increment the last level index by 1
        if (isset($indexes[$maxLevel])) {

            $indexes[$maxLevel]++;

        }

        // Update the index hierarchy if we have reached the max index in the collection
        for ($i = $maxLevel; $i > 0; $i--) {

            if (!isset($indexes[$i])) {

                $indexes[$i] = 0;

            } elseif (
                isset($counts[$i])
                && $indexes[$i] > $counts[$i] - 1
            ) {

                // Setting the level count to null mean that it will have to be recalculated
                $counts[$i] = null;

                // Set the current level to 0 and increment the n-1 level index
                $indexes[$i] = 0;
                $indexes[$i - 1]++;

                // If the first level index is over the count that's the end of the references
                if ($i === 1) {

                    return true;

                }

            } else {

                break;

            }

        }

        return false;

    }

}