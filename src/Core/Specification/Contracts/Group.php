<?php

namespace TestBucket\Core\Specification\Contracts;

interface Group
{
    public function getName(): ?string;

    public function getProperties(): ?array;

    public function setProperty(string $propertyName, string $propertyType);

    public function getProperty(string $propertyName): Property;

    public function addPropertyValue(string $propertyName, bool $isValid, $value);

    public function getPropertyValues(string $propertyName);
}
