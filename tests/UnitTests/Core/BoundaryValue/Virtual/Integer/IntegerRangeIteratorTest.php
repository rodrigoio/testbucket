<?php

namespace TestBucket\Test\UnitTests\Core\BoundaryValue\Virtual\Integer;

use TestBucket\Core\BoundaryValue\Virtual\Integer\IntegerFactory;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group virtual_integer_range_iterator
 * @group virtual_integer
 * @group virtual
 */
class IntegerRangeIteratorTest extends BaseUnitTestCase
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

    public function testIteration()
    {
        $factory = $this->factory;
        $list = $factory->createRangeList();

        $list->add($factory->createRange($factory->createElement(1), $factory->createElement(10)));
        $list->add($factory->createRange($factory->createElement(11), $factory->createElement(20)));
        $list->add($factory->createRange($factory->createElement(21), $factory->createElement(30)));
        $iterator = $list->getIterator();

        $asserts = [
            0 => [1, 10],
            1 => [11, 20],
            2 => [21, 30],
        ];

        while ($iterator->valid()) {
            $item = $iterator->current();
            $assert = $asserts[$iterator->key()];
            $this->assertEquals($assert[0], $item->getStartValue()->getValue());
            $this->assertEquals($assert[1], $item->getEndValue()->getValue());
            $iterator->next();
        }

        while ($iterator->valid()) {
            $item = $iterator->current();
            $assert = $asserts[$iterator->key()];
            $this->assertEquals($assert[0], $item->getStartValue()->getValue());
            $this->assertEquals($assert[1], $item->getEndValue()->getValue());
            $iterator->next();
        }
    }
}
