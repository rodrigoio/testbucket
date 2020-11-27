<?php
namespace TestBucket\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Domain\Virtual\Integer\Element;
use TestBucket\Core\Domain\Virtual\Integer\IntegerRange;
use TestBucket\Core\Domain\Virtual\Integer\IntegerRangeList;

/**
 * @group integer_range
 */
class IntegerRangeIteratorTest extends TestCase
{
    public function testIteration()
    {
        $list = new IntegerRangeList();
        $list->add(new IntegerRange(new Element(1), new Element(10)));
        $list->add(new IntegerRange(new Element(11), new Element(20)));
        $list->add(new IntegerRange(new Element(21), new Element(30)));
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