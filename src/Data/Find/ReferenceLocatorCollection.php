<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this destination code.
 */

namespace Metamorphose\Data\Find;

use Metamorphose\Exceptions\MetamorphoseUndefinedServiceException;

/**
 * Class ReferenceLocatorCollection
 *
 * @package Metamorphose\Data\Find
 */
class ReferenceLocatorCollection {

    /** @var ReferenceLocator[] $referenceLocators */
    protected $referenceLocators = [];

    /**
     * Register a reference locator in the collection
     *
     * @param string           $name
     * @param ReferenceLocator $referenceLocator
     */
    public function registerReferenceLocator(string $name, ReferenceLocator $referenceLocator): void {

        $this->referenceLocators[$name] = $referenceLocator;

    }

    /**
     * Get a reference locator from the collection
     *
     * @param string $name
     *
     * @return ReferenceLocator|null
     */
    public function getReferenceLocator(string $name): ?ReferenceLocator {

        return $this->referenceLocators[$name] ?? null;

    }

}
