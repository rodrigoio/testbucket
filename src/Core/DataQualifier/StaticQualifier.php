<?php

namespace TestBucket\Core\DataQualifier;

use TestBucket\Core\Specification\Contracts\DataQualifier;

class StaticQualifier implements DataQualifier
{
    /**
     * @var mixed
     */
    private $propertyValues;

    public function setInputData(array $propertyValues)
    {
        $this->propertyValues = $propertyValues;
    }

    public function getOutputData(): array
    {
        $output = [];
        foreach ($this->propertyValues as $propertyValue) {
            $output[] = new QualifiedValueImp(true, $propertyValue);
        }
        return $output;
    }
}
