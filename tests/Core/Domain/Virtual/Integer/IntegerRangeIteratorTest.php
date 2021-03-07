<?php
namespace TestBucket\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Domain\Virtual\Integer\IntegerAbstractFactory;

/**
 * @group virtual_integer_range_iterator
 * @group virtual_integer
 * @group virtual
 */
class IntegerRangeIteratorTest extends TestCase
{
    /**
     * @var IntegerAbstractFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = new IntegerAbstractFactory();
    }

    public function testIteration()
    {
        $list = $this->factory->createRangeList();

        $list->add($this->factory->createRange($this->factory->createElement(1), $this->factory->createElement(10)));
        $list->add($this->factory->createRange($this->factory->createElement(11), $this->factory->createElement(20)));
        $list->add($this->factory->createRange($this->factory->createElement(21), $this->factory->createElement(30)));
        $iterator = $list->getIterator();

        $asserts = [
            0 => [1, 10],
            1 => [11, 20],
            2 => [21, 30],
        ];

        foreach ($iterator as $key=>$item) {
            $assert = $asserts[$key];
            $this->assertEquals($assert[0], $item->getStartValue()->getValue());
            $this->assertEquals($assert[1], $item->getEndValue()->getValue());
        }

        // test rewind
        foreach ($iterator as $key=>$item) {
            $assert = $asserts[$key];
            $this->assertEquals($assert[0], $item->getStartValue()->getValue());
            $this->assertEquals($assert[1], $item->getEndValue()->getValue());
        }
    }
}