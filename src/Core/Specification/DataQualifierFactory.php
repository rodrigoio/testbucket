<?php

namespace TestBucket\Core\Specification;

interface DataQualifierFactory
{
    public function createDataQualifier(string $type, array $data, SpecificationFactory $factory): DataQualifier;
}
