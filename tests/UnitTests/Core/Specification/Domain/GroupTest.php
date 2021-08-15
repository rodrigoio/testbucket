<?php

namespace TestBucket\Tests\Core\Specification\Domain;

use TestBucket\Core\Specification\Contracts\Property;
use TestBucket\Core\Specification\Contracts\PropertyValue;
use TestBucket\Core\Specification\Domain\Group;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group specification_domain
 * @group specification
 */
class GroupTest extends BaseUnitTestCase
{
    public function testCreateNewGroup()
    {
        $name = "user_form";
        $group = new Group($name);
        $this->assertEquals($name, $group->getName());

        $propertyName = "name";
        $propertyType = "static";
        $group->setProperty($propertyName, $propertyType);

        $retrievedProperty = $group->getProperty($propertyName);
        $this->assertInstanceOf(Property::class, $retrievedProperty);
        $this->assertEquals($propertyName, $retrievedProperty->getName());
        $this->assertEquals($propertyType, $retrievedProperty->getType());

        $valueOfProperty = "bob";
        $group->addPropertyValue($propertyName, false, $valueOfProperty);

        $propertyValues = $group->getPropertyValues($propertyName);
        $this->assertIsArray($propertyValues);
        $this->assertInstanceOf(PropertyValue::class, $propertyValues[0]);
        $this->assertEquals($valueOfProperty, $propertyValues[0]->getValue());
        $this->assertEquals(false, $propertyValues[0]->isValid());

        $otherValueProperty = "alice";
        $group->addPropertyValue($propertyName, true, $otherValueProperty);
        $propertyValues = $group->getPropertyValues($propertyName);
        $this->assertCount(2, $propertyValues);
        $this->assertEquals($otherValueProperty, $propertyValues[1]->getValue());
        $this->assertEquals(true, $propertyValues[1]->isValid());

        // Extract Information from PropertyValue
        $this->assertEquals($propertyName, $propertyValues[1]->getProperty()->getName());
        $this->assertEquals($propertyType, $propertyValues[1]->getProperty()->getType());
        $this->assertEquals($name, $propertyValues[1]->getProperty()->getGroup()->getName());
    }
}
