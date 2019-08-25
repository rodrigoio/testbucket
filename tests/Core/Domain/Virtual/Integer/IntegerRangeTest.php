<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;

/**
 * @group Integer
 */
class IntegerRangeTest extends TestCase
{
    public function testStartAndEndValues()
    {
        $range = new IntegerRange(
            new Element(9),
            new Element(15)
        );

        $this->assertEquals(new Element(9), $range->getStartValue());
        $this->assertEquals(new Element(15), $range->getEndValue());

        $this->assertFalse( $range->has(new Element(8)) );
        $this->assertTrue( $range->has(new Element(9)) );
        $this->assertTrue( $range->has(new Element(10)) );
        $this->assertTrue( $range->has(new Element(14)) );
        $this->assertTrue( $range->has(new Element(15)) );
        $this->assertFalse( $range->has(new Element(16)) );
    }

    public function testFromIntegerToInfinityRange()
    {
        $range = new IntegerRange(new Element(9), new Element());

        $this->assertFalse( $range->has(new Element(-99)) );
        $this->assertFalse( $range->has(new Element(0)) );
        $this->assertFalse( $range->has(new Element(1)) );
        $this->assertFalse( $range->has(new Element(8)) );
        $this->assertTrue( $range->has(new Element(9)) );
        $this->assertTrue( $range->has(new Element(16)) );
        $this->assertTrue( $range->has(new Element(1000000)) );
    }

    public function testFromInfinityToInterger()
    {
        $range = new IntegerRange(new Element(), new Element(9));

        $this->assertTrue( $range->has(new Element(-1)) );
        $this->assertTrue( $range->has(new Element(1)) );
        $this->assertTrue( $range->has(new Element(0)) );
        $this->assertTrue( $range->has(new Element(8)) );
        $this->assertTrue( $range->has(new Element(9)) );
        $this->assertFalse( $range->has(new Element(10)) );
        $this->assertFalse( $range->has(new Element(16)) );
    }

    public function testAddDomain()
    {
        $rangeA = new IntegerRange(new Element(1), new Element(9));
        $rangeB = new IntegerRange(new Element(7), new Element(15));
        $rangeC = $rangeA->add($rangeB);

        $this->assertEquals(1, $rangeC->getStartValue()->getValue());
        $this->assertEquals(15, $rangeC->getEndValue()->getValue());

        $rangeA = new IntegerRange(new Element(15), new Element(18));
        $rangeB = new IntegerRange(new Element(1), new Element(16));
        $rangeC = $rangeA->add($rangeB);

        $this->assertEquals(1, $rangeC->getStartValue()->getValue());
        $this->assertEquals(18, $rangeC->getEndValue()->getValue());

        $rangeA = new IntegerRange(new Element(1), new Element(20));
        $rangeB = new IntegerRange(new Element(5), new Element(17));
        $rangeC = $rangeA->add($rangeB);

        $this->assertEquals(1, $rangeC->getStartValue()->getValue());
        $this->assertEquals(20, $rangeC->getEndValue()->getValue());

        $rangeA = new IntegerRange(new Element(18), new Element(26));
        $rangeB = new IntegerRange(new Element(-92), new Element(57));
        $rangeC = $rangeA->add($rangeB);

        $this->assertEquals(-92, $rangeC->getStartValue()->getValue());
        $this->assertEquals(57, $rangeC->getEndValue()->getValue());

        $rangeA = new IntegerRange(new Element(1), new Element(10));
        $rangeB = new IntegerRange(new Element(18), new Element(22));
        $rangeC = $rangeA->add($rangeB);

        $this->assertInstanceOf(CompositeIntegerRange::class, $rangeC);

        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(10)) );
        $this->assertFalse( $rangeC->has(new Element(11)) );

        $this->assertFalse( $rangeC->has(new Element(17)) );
        $this->assertTrue( $rangeC->has(new Element(18)) );
        $this->assertTrue( $rangeC->has(new Element(22)) );
        $this->assertFalse( $rangeC->has(new Element(23)) );
    }

//    public function testSubtractDomain()
//    {
//
//    }
//
//    public function testIntersectDomain()
//    {
//
//    }
//
//    public function testExcludeIntersect()
//    {
//
//    }

    public function testInvalidRangeStartValue()
    {
        try {
            new IntegerRange(
                new Element('10'),
                new Element(9)
            );
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The arguments must be integers.', $e->getMessage());
        }
    }

    public function testInvalidRangeEndValue()
    {
        try {
            new IntegerRange(
                new Element(10),
                new Element([])
            );
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('The arguments must be integers.', $e->getMessage());
        }
    }
}
