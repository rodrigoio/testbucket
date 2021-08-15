<?php

namespace TestBucket\Tests\UnitTests\Core\Specification;

use TestBucket\Core\DataQualifier\Factory as DataQualifierFactory;
use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Domain\Factory as SpecificationFactory;
use TestBucket\Core\Specification\File;
use TestBucket\Core\Specification\Loader;
use TestBucket\Core\Specification\V1Validator;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group specification_loader
 * @group specification
 */
class LoaderTest extends BaseUnitTestCase
{
    public function tearDown()
    {
        parent::tearDown();
    }

    private function getLoader($fileName): Loader
    {
        $fullPath =
            getcwd() . DIRECTORY_SEPARATOR .
            'tests' . DIRECTORY_SEPARATOR .
            'TestSpecFiles' . DIRECTORY_SEPARATOR .
            $fileName;

        return new Loader(
            new File($fullPath),
            new V1Validator(),
            new DataQualifierFactory(),
            new SpecificationFactory()
        );
    }

    public function testLoadSpecFileWithStaticValue()
    {
        $loader = $this->getLoader('v1/001_spec.yaml');
        $group = $loader->loadData();

        $this->assertInstanceOf(Group::class, $group);
        $this->assertEquals('UserForm', $group->getName());
        $this->assertEquals('name', $group->getProperty('name')->getName());
        $this->assertEquals('static', $group->getProperty('name')->getType());

        $propertyValues = $group->getProperty('name')->getValues();
        $this->assertEquals('bob', $propertyValues[0]->getValue());
        $this->assertEquals(true, $propertyValues[0]->isValid());
        $this->assertEquals('alice', $propertyValues[1]->getValue());
        $this->assertEquals(true, $propertyValues[1]->isValid());
    }

    public function testLoadSpecFileWithIntegerRangeValues()
    {
        $loader = $this->getLoader('v1/002_spec.yaml');
        $group = $loader->loadData();

        $this->assertInstanceOf(Group::class, $group);
        $this->assertEquals('Form02', $group->getName());
        $this->assertEquals('age', $group->getProperty('age')->getName());
        $this->assertEquals('integer_range', $group->getProperty('age')->getType());

        $propertyValues = $group->getProperty('age')->getValues();
        $this->assertEquals(4, count($propertyValues));
        $this->assertEquals(18, $propertyValues[0]->getValue());
        $this->assertEquals(80, $propertyValues[1]->getValue());
        $this->assertEquals(17, $propertyValues[2]->getValue());
        $this->assertEquals(81, $propertyValues[3]->getValue());
    }
}
