<?php

namespace TestBucket\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Group as GroupInterface;
use TestBucket\Core\Specification\Contracts\Property as PropertyInterface;

class Group implements GroupInterface
{
    private $name;
    private $properties;

    public function __construct(?string $name)
    {
        $this->name = $name;
        $this->properties = [];
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getProperties(): ?array
    {
        return $this->properties;
    }

    public function setProperty(string $propertyName, string $propertyType)
    {
        $this->properties[$propertyName] = new Property($propertyName, $propertyType, $this);
    }

    public function getProperty(string $propertyName): PropertyInterface
    {
        return $this->properties[$propertyName];
    }

    public function addPropertyValue(string $propertyName, bool $isValid, $value)
    {
        $this->getProperty($propertyName)->addValue($isValid, $value);
    }

    public function getPropertyValues(string $propertyName)
    {
        return $this->getProperty($propertyName)->getValues();
    }
}
