<?php
namespace App\Test\Core\Range;

use App\Core\Range\IntegerRange;
use PHPUnit\Framework\TestCase;

/**
 * @group Range
 */
class IntegerRangeTest extends TestCase
{
    public function testInclusiveStartAndEndValues()
    {
        $range = new IntegerRange(9, 15);
        $this->assertFalse( $range->has(8) );
        $this->assertTrue( $range->has(9) );
        $this->assertTrue( $range->has(10) );
        $this->assertTrue( $range->has(14) );
        $this->assertTrue( $range->has(15) );
        $this->assertFalse( $range->has(16) );

        $this->assertEquals( 9, $range->getStartValue() );
        $this->assertEquals( true, $range->isStartIncluse() );
        $this->assertEquals( 15, $range->getEndValue() );
        $this->assertEquals( true, $range->isEndIncluse() );
    }

    public function testNonInclusiveStartAndValue()
    {
        $range = new IntegerRange(9, 15, false);
        $this->assertFalse( $range->has(8) );
        $this->assertFalse( $range->has(9) );
        $this->assertTrue( $range->has(10) );
        $this->assertTrue( $range->has(15) );
        $this->assertFalse( $range->has(16) );

        $this->assertEquals( 9, $range->getStartValue() );
        $this->assertEquals( false, $range->isStartIncluse() );
        $this->assertEquals( 15, $range->getEndValue() );
        $this->assertEquals( true, $range->isEndIncluse() );
    }

    public function testNonInclusiveStartAndEndValues()
    {
        $range = new IntegerRange(9, 15, false, false);
        $this->assertFalse( $range->has(0) );
        $this->assertFalse( $range->has(9) );
        $this->assertTrue( $range->has(10) );
        $this->assertTrue( $range->has(14) );
        $this->assertFalse( $range->has(15) );
        $this->assertFalse( $range->has(16) );

        $this->assertEquals( 9, $range->getStartValue() );
        $this->assertEquals( false, $range->isStartIncluse() );
        $this->assertEquals( 15, $range->getEndValue() );
        $this->assertEquals( false, $range->isEndIncluse() );
    }

    public function testNonInclusiveEndValue()
    {
        $range = new IntegerRange(9, 15, true, false);
        $this->assertFalse( $range->has(0) );
        $this->assertTrue( $range->has(9) );
        $this->assertTrue( $range->has(10) );
        $this->assertTrue( $range->has(14) );
        $this->assertFalse( $range->has(15) );
        $this->assertFalse( $range->has(16) );

        $this->assertEquals( 9, $range->getStartValue() );
        $this->assertEquals( true, $range->isStartIncluse() );
        $this->assertEquals( 15, $range->getEndValue() );
        $this->assertEquals( false, $range->isEndIncluse() );
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRange()
    {
        $range = new IntegerRange(10, 9);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRangeStartValue()
    {
        $range = new IntegerRange('10', 9);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidRangeEndValue()
    {
        $range = new IntegerRange(10, []);
    }
}
