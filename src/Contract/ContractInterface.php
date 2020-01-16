<?php

namespace Metamorphose\Contract;

interface ContractInterface {

    /**
     * @return array
     */
    public function getFormatters();

    /**
     * @return ContractField[]
     */
    public function getFields();

}
