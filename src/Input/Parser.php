<?php
/**
 * This file is part of the Metamorphose package.
 *
 * Copyright (c) 2020 Pierre-Julien Mazenot <pj.mazenot@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Metamorphose\Input;

use Metamorphose\Data\DataSet;

abstract class Parser implements ParserInterface {

    /** Constant to override with the real name */
    const NAME = '';

    /** @var DataSet $parsedData */
    protected $parsedData;

    public function getName(): string {

        return static::NAME;

    }

    public function getParsedData(): DataSet {

        return $this->parsedData;

    }

    public function parseArray(array $array): void {

        $this->parsedData = new DataSet($array);

    }

    public function parseFile(string $filePath): void {

        $fileContent = file_get_contents($filePath);

        $this->parseString($fileContent);

    }

}
