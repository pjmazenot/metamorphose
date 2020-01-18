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

interface ParserInterface {

    public function getName(): string;

    public function getParsedData(): DataSet;

    public function parseArray(array $array);

    public function parseFile(string $filePath);

    public function parseString(string $string);

}
