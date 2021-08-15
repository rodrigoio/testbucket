<?php
//
//namespace TestBucket\Entity;
//
//use Doctrine\Common\Collections\ArrayCollection;
//use TestBucket\Core\Specification\Collection;
//use TestBucket\Core\Specification\Group;
//use TestBucket\Core\Specification\Property;
//
//class Grouping implements Group
//{
//    private $id;
//    private $name;
//
//    /**
//     * @var Collection
//     */
//    private $properties;
//
//    public function __construct()
//    {
//        $this->properties = new ArrayCollection();
//    }
//
//    public function getId()
//    {
//        return $this->id;
//    }
//
//    public function getName()
//    {
//        return $this->name;
//    }
//
//    public function setName($name): void
//    {
//        $this->name = $name;
//    }
//
//    public function addProperty(Property $property): void
//    {
//        $property->setGroup($this);
//        $this->properties->add($property);
//    }
//
//    /**
//     * @return Collection
//     */
//    public function getProperties()
//    {
//        return $this->properties;
//    }
//}
