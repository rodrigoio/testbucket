<?php

namespace TestBucket\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

//use TestBucket\Entity\TestCase as EntityTestCase;
//use TestBucket\Entity\Grouping;
//use TestBucket\Entity\Property;
//use TestBucket\Entity\PropertyValue;

class BaseTestCase extends TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function setUp()
    {
        parent::setUp();
//        $this->resetEntityManager();
//
//        $schemaTool = new SchemaTool($this->entityManager);
//        $schemaTool->createSchema([
//            $this->entityManager->getClassMetadata(Property::class),
//            $this->entityManager->getClassMetadata(PropertyValue::class),
//            $this->entityManager->getClassMetadata(EntityTestCase::class),
//        ]);
    }

//    public function resetEntityManager()
//    {
//        $isDevMode = true;
//        $config = Setup::createXMLMetadataConfiguration(
//            [getenv("ENTITY_PATH_DIR")],
//            $isDevMode,
//            null,
//            null,
//            false
//        );
//
//        $this->entityManager = EntityManager::create([
//            'driver' => 'pdo_sqlite',
//            'path' => getenv('TESTBUCKET_DIR'),
//        ], $config);
//    }

    public function dump($object, $maxDepth=2)
    {
        \Doctrine\Common\Util\Debug::dump($object, $maxDepth);
    }
}
