<?php

namespace TestBucket\Repository;

use Doctrine\ORM\EntityRepository;
use TestBucket\Core\Specification\Group;
use TestBucket\Core\Specification\SpecificationRepository;

class GroupingRepository extends EntityRepository implements SpecificationRepository
{
    public function save(Group $testGroup)
    {
        $this->getEntityManager()->persist($testGroup);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $name
     * @return Group
     */
    public function findOneByName(string $name): Group
    {
        return $this->findOneBy(['name' => $name]);
    }
}
