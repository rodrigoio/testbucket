<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\IntegerRangeSet;

/**
 * @group integer_range
 */
class IntegerRangeSetTest extends TestCase
{
    public function testAdditionOfNonCrossDomains()
    {
        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(0), new Element(5)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(10), new Element(15)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(20), new Element(25)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(30), new Element(40)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(-1)) );
        $this->assertTrue( $integerRangeSet->has(new Element(0)) );
        $this->assertTrue( $integerRangeSet->has(new Element(5)) );
        $this->assertFalse( $integerRangeSet->has(new Element(6)) );

        $this->assertFalse( $integerRangeSet->has(new Element(9)) );
        $this->assertTrue( $integerRangeSet->has(new Element(10)) );
        $this->assertTrue( $integerRangeSet->has(new Element(15)) );
        $this->assertFalse( $integerRangeSet->has(new Element(16)) );

        $this->assertFalse( $integerRangeSet->has(new Element(19)) );
        $this->assertTrue( $integerRangeSet->has(new Element(20)) );
        $this->assertTrue( $integerRangeSet->has(new Element(25)) );
        $this->assertFalse( $integerRangeSet->has(new Element(26)) );

        $this->assertFalse( $integerRangeSet->has(new Element(29)) );
        $this->assertTrue( $integerRangeSet->has(new Element(30)) );
        $this->assertTrue( $integerRangeSet->has(new Element(40)) );
        $this->assertFalse( $integerRangeSet->has(new Element(41)) );
    }

    public function testAdditionOfCrossDomains()
    {
        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(15), new Element(20)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(19), new Element(25)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(11), new Element(18)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(10)) );
        $this->assertTrue( $integerRangeSet->has(new Element(11)) );
        $this->assertTrue( $integerRangeSet->has(new Element(25)) );
        $this->assertFalse( $integerRangeSet->has(new Element(26)) );
    }

    public function testAdditionByPrecision()
    {
        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(0), new Element(5)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(6), new Element(11)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(12), new Element(24)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(25), new Element(30)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(-1)) );
        $this->assertTrue( $integerRangeSet->has(new Element(0)) );
        $this->assertTrue( $integerRangeSet->has(new Element(30)) );
        $this->assertFalse( $integerRangeSet->has(new Element(31)) );
    }

    public function testSubtractFromOneRange()
    {
        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(1), new Element(3)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(5), new Element(7)));
        $integerRangeSet->applyDifference(new IntegerRange(new Element(3), new Element(5)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(0)) );
        $this->assertTrue( $integerRangeSet->has(new Element(1)) );
        $this->assertTrue( $integerRangeSet->has(new Element(2)) );
        $this->assertFalse( $integerRangeSet->has(new Element(3)) );
        $this->assertFalse( $integerRangeSet->has(new Element(5)) );
        $this->assertTrue( $integerRangeSet->has(new Element(6)) );
        $this->assertTrue( $integerRangeSet->has(new Element(7)) );
        $this->assertFalse( $integerRangeSet->has(new Element(8)) );

        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(1), new Element(6)));
        $integerRangeSet->applyDifference(new IntegerRange(new Element(3), new Element(5)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(0)) );
        $this->assertTrue( $integerRangeSet->has(new Element(1)) );
        $this->assertTrue( $integerRangeSet->has(new Element(2)) );
        $this->assertFalse( $integerRangeSet->has(new Element(3)) );
        $this->assertFalse( $integerRangeSet->has(new Element(5)) );
        $this->assertTrue( $integerRangeSet->has(new Element(6)) );
        $this->assertFalse( $integerRangeSet->has(new Element(7)) );

        $integerRangeSet = new IntegerRangeSet();
        $integerRangeSet->applyUnion(new IntegerRange(new Element(7), new Element(9)));
        $integerRangeSet->applyUnion(new IntegerRange(new Element(11), new Element(12)));
        $integerRangeSet->applyDifference(new IntegerRange(new Element(6), new Element(11)));
        //
        $this->assertFalse( $integerRangeSet->has(new Element(11)) );
        $this->assertTrue( $integerRangeSet->has(new Element(12)) );
        $this->assertFalse( $integerRangeSet->has(new Element(13)) );
    }

    /*
    public function testOppositeDomain()
    {
        //TODO - implement oppositeDomain...
    }
    */
}
