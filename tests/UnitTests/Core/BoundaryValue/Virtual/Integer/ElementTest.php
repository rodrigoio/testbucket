<?php

namespace TestBucket\Test\UnitTests\Core\BoundaryValue\Virtual\Integer;

use TestBucket\Core\BoundaryValue\Virtual\Integer\IntegerFactory;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group virtual_integer_element
 * @group virtual_integer
 * @group virtual
 */
class ElementTest extends BaseUnitTestCase
{
    /**
     * @var IntegerFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = new IntegerFactory();
    }

    public function testElementAgainstElement()
    {
        $element1 = $this->factory->createElement(10);
        $element2 = $this->factory->createElement( 25);
        $element3 = $this->factory->createElement( 10);

        $this->assertFalse( $element1->equals($element2) );
        $this->assertTrue( $element1->equals($element3) );
    }

    public function testIncrementAndDecrement()
    {
        $element1 = $this->factory->createElement( 10);
        $element2 = $this->factory->createElement( 9);
        $element3 = $this->factory->createElement( 11);

        $before = $element1->prev();
        $after = $element1->next();

        $this->assertTrue( $element2->equals($before) );
        $this->assertTrue( $element3->equals($after) );
        $this->assertTrue( $element1->equals($this->factory->createElement( 10)) );
    }

    public function testIncrementAndDecrementWithInfinityValue()
    {
        $element = $this->factory->createElement(null);

        $this->assertEquals(null, $element->getValue());

        $previousElement = $element->prev();
        $this->assertEquals(null, $previousElement->getValue());

        $nextElement = $element->next();
        $this->assertEquals(null, $nextElement->getValue());
    }
}
