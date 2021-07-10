<?php

namespace TestBucket\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use TestBucket\Core\Specification\Group;
use TestBucket\Core\Specification\Property as PropertyInterface;
use TestBucket\Core\Specification\PropertyValue;

class Property implements PropertyInterface
{
    private $id;
    private $name;
    private $type;

    /**
     * @var Group
     */
    private $grouping;

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
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->grouping;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group): void
    {
        $this->grouping = $group;
    }

    public function addValue(PropertyValue $propertyValue): void
    {
        $propertyValue->setProperty($this);
        $this->values->add($propertyValue);
    }

    public function getValues()
    {
        return $this->values;
    }
}
