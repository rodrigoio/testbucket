<?php

namespace TestBucket\Core\DataQualifier;

use InvalidArgumentException;
use TestBucket\Core\BoundaryValue\Virtual\Integer\IntegerFactory;
use TestBucket\Core\Specification\Contracts\DataQualifier;
use TestBucket\Core\Specification\Contracts\DataQualifierFactory;

class Factory implements DataQualifierFactory
{
    private $map;

    public function __construct()
    {
        $this->map = [
            'static' => new StaticQualifier(),
            'integer_range' => new IntegerLimitValueQualifier(new IntegerFactory()),
        ];
    }

    private function getDataQualifier(string $type): DataQualifier
    {
        if (!isset($this->map[$type])) {
            throw new InvalidArgumentException("Property type not found: $type");
        }
        return $this->map[$type];
    }

    public function createDataQualifier(string $type, array $data): DataQualifier
    {
        $qualifier = $this->getDataQualifier($type);
        $qualifier->setInputData($data);
        return $qualifier;
    }
}
