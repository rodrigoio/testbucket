<?php

namespace TestBucket\Core\Specification\Contracts;

interface PropertyValue
{
    public function __construct(Property $property, bool $isValid, $value);
    public function getValue();
    public function isValid();
    public function getProperty(): Property;
}
