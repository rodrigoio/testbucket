<?php

namespace TestBucket\Repository;

use Doctrine\ORM\EntityRepository;
use TestBucket\Entity\TestGroup;

class TestGroupRepository extends EntityRepository
{
    public function save(TestGroup $testGroup)
    {
        $this->getEntityManager()->persist($testGroup);
        $this->getEntityManager()->flush();
    }
}
