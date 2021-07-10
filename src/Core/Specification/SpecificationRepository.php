<?php

namespace TestBucket\Core\Specification;

interface SpecificationRepository
{
    public function save(Group $group);

    public function findOneByName(string $name): Group;
}
