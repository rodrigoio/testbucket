<?php

namespace TestBucket\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class TestProperty
{
    private $id;
    private $name;
    private $type;

    /**
     * @var TestGroup
     */
    private $group;

    /**
     * @var ArrayCollection
     */
    private $values;

    public function __construct()
    {
        $this->values = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return TestGroup
     */
    public function getGroup(): TestGroup
    {
        return $this->group;
    }

    /**
     * @param TestGroup $group
     */
    public function setGroup(TestGroup $group): void
    {
        $this->group = $group;
    }

    public function addValue(TestPropertyValue $testPropertyValue): void
    {
        $testPropertyValue->setProperty($this);
        $this->values->add($testPropertyValue);
    }
}
