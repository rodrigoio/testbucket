<?php

namespace TestBucket\Tests\Repository;

use TestBucket\Tests\AbstractTestCase;
use TestBucket\Entity\TestGroup;
use TestBucket\Entity\TestProperty;
use TestBucket\Entity\TestPropertyValue;

/**
 * @group repository
 */
class TestGroupRepositoryTest extends AbstractTestCase
{
    public function tearDown()
    {
        parent::tearDown();
        if (file_exists(getenv('TESTBUCKET_DIR'))) {
            unlink(getenv('TESTBUCKET_DIR'));
        }
    }

    public function testPersistGroup()
    {
        $testGroupRepository = $this->entityManager->getRepository(TestGroup::class);

        $testGroup = new TestGroup();
        $testGroup->setName("form_user");

        $testProperty = new TestProperty();
        $testProperty->setName("username");
        $testProperty->setType("static");

        $testPropertyValue = new TestPropertyValue();
        $testPropertyValue->setValue("test.user");
        $testPropertyValue->setHash(md5("test.user"));
        $testPropertyValue->setIsValid(false);

        $testProperty->addValue($testPropertyValue);

        $testGroup->addProperty($testProperty);

        $testGroupRepository->save($testGroup);

        $this->assertNotNull($testGroup->getId());
        $this->assertNotNull($testProperty->getId());
        $this->assertEquals($testGroup->getId(), $testProperty->getGroup()->getId());

        $this->assertNotNull($testPropertyValue->getId());
        $this->assertEquals($testProperty->getId(), $testPropertyValue->getProperty()->getId());
    }
}
