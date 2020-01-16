<?php

namespace Metamorphose\Contract;

class ContractValidatorField {

    /** @var bool $mandatory */
    protected $mandatory;

    /** @var string $to */
    protected $to;

    public function __construct(array $fieldData) {

        $this->parseFieldData($fieldData);

    }

    /**
     * @return bool
     */
    public function isMandatory(): bool {

        return $this->mandatory;

    }

    /**
     * @return mixed
     */
    public function getTo() {

        return $this->to;

    }

    protected function parseFieldData(array $fieldData): void {

        if(isset($fieldData['mandatory'])) {
            $this->mandatory = $fieldData['mandatory'];
        }

        if(isset($fieldData['to'])) {
            $this->to = $fieldData['to'];
        }

    }

}
