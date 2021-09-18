<?php

namespace TestBucket\Core\Specification\Contracts;

interface DataQualifier
{
    public function setInputData(array $propertyValues);
    public function getOutputData(): array;
}
