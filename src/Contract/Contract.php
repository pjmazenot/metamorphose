<?php

namespace Metamorphose\Contract;

class Contract implements ContractInterface {

    const TYPE_COLLECTION = 'collection';
    const TYPE_OBJECT = 'object';

    /** @var array $parsers */
    protected $parsers = [];

    /** @var array $formatters */
    protected $formatters = [];

    /** @var array $options */
    protected $options = [];

    /** @var string $type */
    protected $type;

    /** @var ContractField[] $fields */
    protected $fields = [];

    public function __construct(string $filePath) {

        $this->parseFile($filePath);

    }

    public function getDefaultParserName(): string {

        return $this->parsers[0];

    }

    public function isParserAuthorizedOrThrow(string $parserName): bool {

        if(in_array($parserName, $this->parsers)) {

            return true;

        }

        throw new \Exception('The parser "' . $parserName . '" is not available for this contract');

    }

    public function getDefaultFormatterName(): string {

        return $this->formatters[0];

    }

    public function isFormatterAuthorizedOrThrow(string $formatterName): bool {

        if(in_array($formatterName, $this->formatters)) {

            return true;

        }

        throw new \Exception('The formatter "' . $formatterName . '" is not available for this contract');

    }

    public function getFormatters() {

        return $this->formatters;

    }

    public function getOptions() {

        return $this->options;

    }

    public function getType() {

        return $this->type;

    }

    public function getFields() {

        return $this->fields;

    }

    protected function parseFile(string $filePath): void {

        $contractData = json_decode(file_get_contents($filePath), true);

        if(isset($contractData['parsers'])) {

            $this->parsers = $contractData['parsers'];

        } else {

            throw new \Exception('The contract needs to have at least one parser');

        }

        if(isset($contractData['formatters'])) {

            $this->formatters = $contractData['formatters'];

        } else {

            throw new \Exception('The contract needs to have at least one formatter');

        }

        if(isset($contractData['options'])) {

            $this->options = $contractData['options'];

        }

        if(isset($contractData['type'])) {

            if(empty($contractData['type'])) {

                $this->type = self::TYPE_OBJECT;

            } elseif(in_array($contractData['type'], [self::TYPE_COLLECTION, self::TYPE_OBJECT])) {

                $this->type = $contractData['type'];

            } else {
                throw new \Exception('The contract needs to have a valid type defined');
            }
        }

        if(isset($contractData['fields'])) {

            foreach($contractData['fields'] as $fieldData) {

                $this->fields[] = new ContractField($fieldData);

            }

        }

    }

}
