<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Data;

/**
 * Interface DataValidatorInterface
 *
 * @package Metamorphose\Data
 */
interface DataValidatorInterface {

    /**
     * Get the data validator name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Validate the data
     *
     * @param mixed $data
     * @param array $params
     *
     * @return bool
     */
    public function validate($data, array $params = []): bool;

}
