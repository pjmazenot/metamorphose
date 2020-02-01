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

/**
 * Class Reference
 *
 * @package Metamorphose\Core\Engine
 */
class Reference {

    protected $key;
    protected $value;
    protected $isLast = true;
    protected $indexes = [];

    public function __construct(string $key, $value, bool $isLast, array $indexes = []) {

        $this->key = $key;
        $this->value = $value;
        $this->isLast = $isLast;
        $this->indexes = $indexes;

    }

    /**
     * @return string
     */
    public function getKey(): string {

        return $this->key;

    }

    /**
     * @return mixed
     */
    public function getValue() {

        return $this->value;

    }

    /**
     * @return bool
     */
    public function isLast(): bool {

        return $this->isLast;

    }

    /**
     * @return array
     */
    public function getIndexes(): array {

        return $this->indexes;

    }

}