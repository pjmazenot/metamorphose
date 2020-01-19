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
 * Interface DataProcessorInterface
 *
 * @package Metamorphose\Data
 */
interface DataProcessorInterface {

    /**
     * Get the data processor name
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Process the data
     *
     * @param mixed $data
     * @param array $params
     *
     * @return mixed
     */
    public function process($data, array $params = []);

}
