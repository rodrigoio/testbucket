<?php

namespace TestBucket\Entity;

class TestPropertyValue
{
    private $id;
    private $hash;
    private $value;
    private $isValid;

    /**
     * @var TestProperty
     */
    private $property;

    public function getId()
    {
        return $this->id;
    }

    public function getHash()
    {
        return $this->hash;
    }

    public function setHash($hash): void
    {
        $this->hash = $hash;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getIsValid()
    {
        return $this->isValid;
    }

    public function setIsValid($isValid): void
    {
        $this->isValid = $isValid;
    }

    /**
     * @return TestProperty
     */
    public function getProperty(): TestProperty
    {
        return $this->property;
    }

    /**
     * @param TestProperty $property
     */
    public function setProperty(TestProperty $property): void
    {
        $this->property = $property;
    }
}
