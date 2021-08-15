<?php
//
//namespace TestBucket\Tests\Repository;
//
//use TestBucket\Tests\BaseTestCase;
//use TestBucket\Repository\EntityFactory;
//use TestBucket\Entity\Grouping;
//use DateTime;
//
///**
// * @group repository
// */
//class GroupRepositoryTest extends BaseTestCase
//{
//    /**
//     * @var EntityFactory
//     */
//    private $factory;
//
//    public function setUp()
//    {
//        parent::setUp();
//        $this->factory = new EntityFactory();
//    }
//
//    public function tearDown()
//    {
//        parent::tearDown();
//        if (file_exists(getenv('TESTBUCKET_DIR'))) {
//            unlink(getenv('TESTBUCKET_DIR'));
//        }
//    }
//
//    public function testPersistGroup()
//    {
//        $testGroupRepository = $this->entityManager->getRepository(Grouping::class);
//
//        $testGroup = $this->factory->createNewGroup();
//        $testGroup->setName("form_user");
//        $this->assertEquals("form_user", $testGroup->getName());
//
//        $testProperty = $this->factory->createNewProperty();
//        $testProperty->setName("username");
//        $testProperty->setType("static");
//        $this->assertEquals("username", $testProperty->getName());
//        $this->assertEquals("static", $testProperty->getType());
//
//        $testPropertyValue = $this->factory->createNewPropertyValue();
//        $testPropertyValue->setValue("test.user");
//        $testPropertyValue->setValid(false);
//        $this->assertEquals("test.user", $testPropertyValue->getValue());
//        $this->assertEquals(false, $testPropertyValue->isValid());
//
//        $testProperty->addValue($testPropertyValue);
//        $testGroup->addProperty($testProperty);
//
//        $testGroupRepository->save($testGroup);
//
//        $this->assertNotNull($testGroup->getId());
//        $this->assertNotNull($testProperty->getId());
//        $this->assertEquals($testGroup->getId(), $testProperty->getGroup()->getId());
//
//        $this->assertNotNull($testPropertyValue->getId());
//        $this->assertEquals($testProperty->getId(), $testPropertyValue->getProperty()->getId());
//    }
//
//    public function testPersistManyTypes()
//    {
//        $testGroupRepository = $this->entityManager->getRepository(Grouping::class);
//
//        $group = $this->factory->createNewGroup();
//        $group->setName("form_user");
//
//        $property = $this->factory->createNewProperty();
//        $property->setName("username");
//        $property->setType("static");
//
//        // integerValue
//        $integerValue = $this->factory->createNewPropertyValue();
//        $integerValue->setValue(11);
//        $this->assertSame(11, $integerValue->getValue());
//        //
//        $this->assertSame(11, $integerValue->getIntegerValue());
//        $this->assertSame(null, $integerValue->getDecimalValue());
//        $this->assertSame(null, $integerValue->isBooleanValue());
//        $this->assertSame(null, $integerValue->getTextValue());
//        $this->assertSame(null, $integerValue->getDatetimeValue());
//
//        // decimalValue
//        $decimalValue = $this->factory->createNewPropertyValue();
//        $decimalValue->setValue(201.78);
//        $this->assertSame(201.78, $decimalValue->getValue());
//        //
//        $this->assertSame(null, $decimalValue->getIntegerValue());
//        $this->assertSame(201.78, $decimalValue->getDecimalValue());
//        $this->assertSame(null, $decimalValue->isBooleanValue());
//        $this->assertSame(null, $decimalValue->getTextValue());
//        $this->assertSame(null, $decimalValue->getDatetimeValue());
//
//        // booleanValue
//        $booleanValue = $this->factory->createNewPropertyValue();
//        $booleanValue->setValue(true);
//        $this->assertSame(true, $booleanValue->getValue());
//        //
//        $this->assertSame(null, $booleanValue->getIntegerValue());
//        $this->assertSame(null, $booleanValue->getDecimalValue());
//        $this->assertSame(true, $booleanValue->isBooleanValue());
//        $this->assertSame(null, $booleanValue->getTextValue());
//        $this->assertSame(null, $booleanValue->getDatetimeValue());
//
//        // textValue
//        $textValue = $this->factory->createNewPropertyValue();
//        $textValue->setValue('test text value');
//        $this->assertSame('test text value', $textValue->getValue());
//        //
//        $this->assertSame(null, $textValue->getIntegerValue());
//        $this->assertSame(null, $textValue->getDecimalValue());
//        $this->assertSame(null, $textValue->isBooleanValue());
//        $this->assertSame('test text value', $textValue->getTextValue());
//        $this->assertSame(null, $textValue->getDatetimeValue());
//
//        // datetimeValue
//        $datetimeValue = $this->factory->createNewPropertyValue();
//        $currentDate = new DateTime();
//        $datetimeValue->setValue($currentDate);
//        $this->assertSame($currentDate, $datetimeValue->getValue());
//        //
//        $this->assertSame(null, $datetimeValue->getIntegerValue());
//        $this->assertSame(null, $datetimeValue->getDecimalValue());
//        $this->assertSame(null, $datetimeValue->isBooleanValue());
//        $this->assertSame(null, $datetimeValue->getTextValue());
//        $this->assertSame($currentDate, $datetimeValue->getDatetimeValue());
//
//        // null
//        $nullValue = $this->factory->createNewPropertyValue();
//        $this->assertSame(null, $nullValue->getValue());
//        $this->assertSame(null, $nullValue->getIntegerValue());
//        $this->assertSame(null, $nullValue->getDecimalValue());
//        $this->assertSame(null, $nullValue->isBooleanValue());
//        $this->assertSame(null, $nullValue->getTextValue());
//        $this->assertSame(null, $nullValue->getDatetimeValue());
//
//        // add values
//        $property->addValue($integerValue);
//        $property->addValue($decimalValue);
//        $property->addValue($booleanValue);
//        $property->addValue($textValue);
//        $property->addValue($datetimeValue);
//        $property->addValue($nullValue);
//        $group->addProperty($property);
//        $testGroupRepository->save($group);
//
//
//        $this->resetEntityManager();
//        $foundGroup = $testGroupRepository->findOneByName($group->getName());
//        $firstProperty = $foundGroup->getProperties()->first();
//
//        foreach ($firstProperty->getValues() as $oneValue) {
//
//            $expectedValue = null;
//            if ($integerValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $integerValue->getIntegerValue();
//            }
//            if ($decimalValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $decimalValue->getDecimalValue();
//            }
//            if ($booleanValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $booleanValue->isBooleanValue();
//            }
//            if ($textValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $textValue->getTextValue();
//            }
//            if ($datetimeValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $datetimeValue->getDatetimeValue();
//            }
//            if ($nullValue->getValue() === $oneValue->getValue()) {
//                $expectedValue = $nullValue->getDatetimeValue();
//            }
//
//            $this->assertSame($expectedValue, $oneValue->getValue());
//        }
//    }
//}
