<?php

namespace TestBucket\Core\DataQualifier;

use TestBucket\Core\Specification\DataQualifier;
use TestBucket\Core\Specification\SpecificationFactory;

class StaticQualifier implements DataQualifier
{
    /**
     * @var mixed
     */
    private $propertyValues;

    /**
     * @var SpecificationFactory
     */
    private $specificationFactory;

    public function setInputData(array $propertyValues, SpecificationFactory $specificationFactory)
    {
        $this->propertyValues = $propertyValues;
        $this->specificationFactory = $specificationFactory;
    }

    public function getOutputData(): array
    {
        return array_map(function($propertyValue){

            $propertyValues = $this->specificationFactory->createNewPropertyValue();
            $propertyValues->setValid(true);
            $propertyValues->setValue($propertyValue);
            return $propertyValues;

        }, $this->propertyValues);
    }
}
