<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\IntegerRangeList;

/**
 * @group integer_range
 */
class IntegerRangeListTest extends TestCase
{
    public function testAddRanges()
    {
        $list = new IntegerRangeList();
        $list->add(new IntegerRange(new Element(1), new Element(10)));
        $list->add(new IntegerRange(new Element(11), new Element(20)));
        $list->add(new IntegerRange(new Element(21), new Element(30)));

        $this->assertEquals(3 , $list->count());
        $this->assertEquals(null, $list->get(10));

        $range = $list->get(2);
        $this->assertEquals(21, $range->getStartValue()->getValue());
        $this->assertEquals(30, $range->getEndValue()->getValue());

        $list->set(new IntegerRange(new Element(90), new Element(100)), 2);

        $range = $list->get(2);
        $this->assertEquals(3 , $list->count());
        $this->assertEquals(90, $range->getStartValue()->getValue());
        $this->assertEquals(100, $range->getEndValue()->getValue());

        $range = $list->last();
        $this->assertEquals(90, $range->getStartValue()->getValue());
        $this->assertEquals(100, $range->getEndValue()->getValue());
    }
}