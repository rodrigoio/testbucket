<?php

namespace TestBucket\Core\Specification;

interface Property
{
    public function getId();
    public function getName();
    public function setName($name): void;
    public function getType();
    public function setType($type): void;
    public function getGroup(): Group;
    public function setGroup(Group $group): void;
    public function addValue(PropertyValue $testPropertyValue): void;
    public function getValues();
}
