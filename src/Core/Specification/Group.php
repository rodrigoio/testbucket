<?php

namespace TestBucket\Core\Specification;

interface Group
{
    public function getId();
    public function getName();
    public function setName($name): void;
    public function addProperty(Property $testProperty): void;
    public function getProperties();
}
