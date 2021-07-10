<?php

namespace TestBucket\Core\Specification;

interface PropertyValue
{
    public function getId();

    public function setValue($value): void;
    public function getValue();

    public function setValid($valid): void;
    public function isValid();

    public function getProperty(): Property;
    public function setProperty(Property $property): void;
}
