# Metamorphose

[![Software License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)

The Metamorphose library is built like an ETL. It will allow you to get data from one or more data sources, transform and
validate it before sending it to one or more destinations.

This makes it the ideal tool to build an importer, an exporter, a proxy, and many more data transformation applications.

Features include:

* Define the whole process using a contract system
* Contract inspector and validator to ensure the integrity of the contract and of the results
* Data extraction from one or multiple sources (string, file, database, custom)
* Data parsing (array, json, csv, xml, yaml, custom)
* Data transformation (many default processors, custom)
* Data validation (many default validators, custom)
* Data formatting (json, csv, xml, yaml, custom)
* Data loading to one or multiple destinations (string, file, database, custom)
* All above components can be customized

## Installation

```bash
composer require pjmazenot/metamorphose
```

## Getting Started

Here is a simple contract example:

```json
{
  "sources": [
    {
      "name": "source",
      "type": "string",
      "parser": "json",
      "structure": "object",
      "options": {},
      "fields": []
    }
  ],
  "destinations": [
    {
      "name": "dest",
      "type": "string",
      "formatter": "json",
      "structure": "object",
      "fields": [
        {
          "name": "firstname",
          "apply": [
            {
              "type": "value",
              "value": "$ref:source.param1"
            }
          ]
        },
        {
          "name": "lastname",
          "apply": [
            {
              "type": "value",
              "value": "$ref:source.param2"
            }
          ]
        }
      ]
    }
  ]
}
```

To apply this transformation your code will look like this:

```php
<?php
$metamorphose = new \Metamorphose\Metamorphose('contract.json');
$metamorphose->extract([
    'source' => [
        'string' => '{"param1": "John","param2": "Smith"}'
    ],
]);
$metamorphose->transform();
$output = $metamorphose->load();

echo $output['dest'];
```

The following example will display:

```
{"firstname": "John","lastname": "Smith"}
```

## Documentation

The documentation is a work in progress. In the meantime you can find a lot of examples in the functional test suite
(`tests/codeception/functional/[...]`).
