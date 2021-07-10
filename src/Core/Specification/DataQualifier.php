<?php

namespace TestBucket\Core\Specification;

interface DataQualifier
{
    public function setInputData(array $propertyValues, SpecificationFactory $specificationFactory);
    public function getOutputData(): array;
}
