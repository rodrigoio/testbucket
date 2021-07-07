<?php

namespace TestBucket\Tests;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\Setup;
use PHPUnit\Framework\TestCase;

use TestBucket\Entity\TestCase as EntityTestCase;
use TestBucket\Entity\TestGroup;
use TestBucket\Entity\TestProperty;
use TestBucket\Entity\TestPropertyValue;

class AbstractTestCase extends TestCase
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    public function setUp()
    {
        parent::setUp();
        $isDevMode = true;
        $config = Setup::createXMLMetadataConfiguration(
            [getenv("ENTITY_PATH_DIR")],
            $isDevMode,
            null,
            null,
            false
        );

        $this->entityManager = EntityManager::create([
            'driver' => 'pdo_sqlite',
            'path' => getenv('TESTBUCKET_DIR'),
        ], $config);

        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema([
            $this->entityManager->getClassMetadata(TestGroup::class),
            $this->entityManager->getClassMetadata(TestProperty::class),
            $this->entityManager->getClassMetadata(TestPropertyValue::class),
            $this->entityManager->getClassMetadata(EntityTestCase::class),
        ]);
    }

    public function dump($object)
    {
        \Doctrine\Common\Util\Debug::dump($object);
    }
}
