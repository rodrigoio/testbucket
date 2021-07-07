<?php

namespace TestBucket\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class TestGroup
{
    private $id;
    private $name;

    /**
     * @var ArrayCollection
     */
    private $properties;

    public function __construct()
    {
        $this->properties = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    public function addProperty(TestProperty $testProperty): void
    {
        $testProperty->setGroup($this);
        $this->properties->add($testProperty);
    }
}
