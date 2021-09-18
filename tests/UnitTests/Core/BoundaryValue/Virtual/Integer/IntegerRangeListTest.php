<?php

namespace TestBucket\Test\UnitTests\Core\BoundaryValue\Virtual\Integer;

use TestBucket\Core\BoundaryValue\Virtual\Integer\IntegerFactory;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group virtual_integer_list
 * @group virtual_integer
 * @group virtual
 */
class IntegerRangeListTest extends BaseUnitTestCase
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

    public function testAddRanges()
    {
        $list = $this->factory->createRangeList();
        $list->add($this->factory->createRange($this->factory->createElement(1), $this->factory->createElement(10)));
        $list->add($this->factory->createRange($this->factory->createElement(11), $this->factory->createElement(20)));
        $list->add($this->factory->createRange($this->factory->createElement(21), $this->factory->createElement(30)));

        $this->assertEquals(3 , $list->count());
        $this->assertEquals(null, $list->get(10));

        $range = $list->get(2);
        $this->assertEquals(21, $range->getStartValue()->getValue());
        $this->assertEquals(30, $range->getEndValue()->getValue());

        $list->set($this->factory->createRange($this->factory->createElement(90), $this->factory->createElement(100)), 2);

        $range = $list->get(2);
        $this->assertEquals(3 , $list->count());
        $this->assertEquals(90, $range->getStartValue()->getValue());
        $this->assertEquals(100, $range->getEndValue()->getValue());

        $range = $list->last();
        $this->assertEquals(90, $range->getStartValue()->getValue());
        $this->assertEquals(100, $range->getEndValue()->getValue());
    }
}
