<?php

namespace TestBucket\Core\DataQualifier;

use TestBucket\Core\Specification\DataQualifier;
use TestBucket\Core\Specification\DataQualifierFactory;
use TestBucket\Core\Specification\SpecificationFactory;
use InvalidArgumentException;

class Factory implements DataQualifierFactory
{
    private $map;

    public function __construct()
    {
        $this->map = [
            'static' => new StaticQualifier(),
        ];
    }

    private function getDataQualifier(string $type): DataQualifier
    {
        if (!isset($this->map[$type])) {
            throw new InvalidArgumentException("Property type not found: $type");
        }
        return $this->map[$type];
    }

    public function createDataQualifier(string $type, array $data, SpecificationFactory $factory): DataQualifier
    {
        $qualifier = $this->getDataQualifier($type);
        $qualifier->setInputData($data, $factory);
        return $qualifier;
    }
}
