<?php

namespace Metamorphose\Contract;

class ContractValidator {

    /** @var array $contract */
    protected $contract;

    public function __construct(string $filePath) {

        $this->contract = json_decode(file_get_contents($filePath), true);

    }

    public function getContract(): array {

        return $this->contract;

    }

    public function checkVsOutputContract($expectedOutputContract) {



    }

}
