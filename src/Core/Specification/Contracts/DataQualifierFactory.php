<?php

namespace TestBucket\Core\Specification\Contracts;

interface DataQualifierFactory
{
    public function createDataQualifier(string $type, array $data): DataQualifier;
}
