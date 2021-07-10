<?php

namespace TestBucket\Core\Specification;

interface SpecificationFactory
{
    public function createNewGroup(): Group;

    public function createNewProperty(): Property;

    public function createNewPropertyValue(): PropertyValue;
}
