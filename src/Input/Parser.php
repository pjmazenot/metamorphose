<?php

namespace Metamorphose\Input;

use Metamorphose\Data\DataSet;

abstract class Parser implements ParserInterface {

    /** @var DataSet $parsedData */
    protected $parsedData;

    public function getParsedData(): DataSet {

        return $this->parsedData;

    }

}
