<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\Value;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group combiner_value
 * @group combiner
 */
class ValueTest extends BaseUnitTestCase
{
    public function testCreateValidValue()
    {
        $mixedValue = "some value";
        $validValue1 = new Value($mixedValue);
        $this->assertEquals($mixedValue, $validValue1->getValue());
        $this->assertTrue( $validValue1->isValid() );

        $mixedValue = "some value";
        $validValue2 = new Value($mixedValue, true);
        $this->assertEquals($mixedValue, $validValue2->getValue());
        $this->assertTrue( $validValue2->isValid() );
    }

    public function testCreateInvalidValue()
    {
        $mixedValue = "some value";
        $invalidValue = new Value($mixedValue, false);
        $this->assertEquals($mixedValue, $invalidValue->getValue());
        $this->assertFalse( $invalidValue->isValid() );
    }
}
