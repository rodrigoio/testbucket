<?php

namespace TestBucket\Test\UnitTests\Core\BoundaryValue\Virtual\Integer;

use TestBucket\Core\BoundaryValue\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\Range;
use TestBucket\Core\BoundaryValue\Virtual\Contracts\RangeSet;
use TestBucket\Core\BoundaryValue\Virtual\Integer\IntegerFactory;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group virtual_integer_range_set
 * @group virtual_integer
 * @group virtual
 */
class IntegerRangeSetTest extends BaseUnitTestCase
{
    /** @var IntegerFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new IntegerFactory();
    }

    public function testAdditionOfNonCrossDomains()
    {
        $integerRangeSet = $this->createRangeSet();

        $integerRangeSet->applyUnion($this->createRange($this->createElement(0), $this->createElement(5)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(10), $this->createElement(15)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(20), $this->createElement(25)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(30), $this->createElement(40)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(-1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(5)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(6)) );

        $this->assertFalse( $integerRangeSet->has($this->createElement(9)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(10)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(15)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(16)) );

        $this->assertFalse( $integerRangeSet->has($this->createElement(19)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(20)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(25)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(26)) );

        $this->assertFalse( $integerRangeSet->has($this->createElement(29)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(30)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(40)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(41)) );
    }

    public function testAdditionOfCrossDomains()
    {
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(15), $this->createElement(20)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(19), $this->createElement(25)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(11), $this->createElement(18)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(10)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(11)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(25)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(26)) );
    }

    public function testAdditionByPrecision()
    {
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(0), $this->createElement(5)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(6), $this->createElement(11)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(12), $this->createElement(24)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(25), $this->createElement(30)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(-1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(30)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(31)) );
    }

    public function testSubtractFromOneRange()
    {
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(1), $this->createElement(3)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(5), $this->createElement(7)));
        $integerRangeSet->applyDifference($this->createRange($this->createElement(3), $this->createElement(5)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(2)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(3)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(5)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(6)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(7)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(8)) );

        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(1), $this->createElement(6)));
        $integerRangeSet->applyDifference($this->createRange($this->createElement(3), $this->createElement(5)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(2)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(3)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(5)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(6)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(7)) );

        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(7), $this->createElement(9)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(11), $this->createElement(12)));
        $integerRangeSet->applyDifference($this->createRange($this->createElement(6), $this->createElement(11)));
        //
        $this->assertFalse( $integerRangeSet->has($this->createElement(11)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(12)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(13)) );
    }


    public function testOppositeDomain()
    {
        // 0 <1 2 3> 4 5 6 7 8 9 10 11 12 13 14
        // 0> 1 2 3 <4 5 6 7 8 9 10 11 12 13 14
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(1), $this->createElement(3)));
        $this->assertFalse( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(3)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(4)) );
        //
        $oppositeSet = $integerRangeSet->oppositeSet();
        $this->assertTrue( $oppositeSet->has($this->createElement(-100)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(-10)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(0)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(1)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(3)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(4)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(40)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(4000)) );

        // 0 1 2 3 4 5> 6 7 8  9 10 11 12 13 14
        // 0 1 2 3 4 5  6 7 8 <9 10 11 12 13 14
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(null), $this->createElement(5)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(9), $this->createElement(null)));
        $this->assertTrue( $integerRangeSet->has($this->createElement(-1000)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(-10)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(5)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(6)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(8)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(9)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(40)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(4000)) );
        //
        $oppositeSet = $integerRangeSet->oppositeSet();
        $this->assertFalse( $oppositeSet->has($this->createElement(5)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(6)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(8)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(9)) );

        // 0 <1 2 3> 4 5 6 7 8 <9 10 11> 12 13 14
        // 0> 1 2 3 <4 5 6 7 8> 9 10 11 <12 13 14
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(1), $this->createElement(3)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(9), $this->createElement(11)));
        $this->assertFalse( $integerRangeSet->has($this->createElement(0)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(1)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(3)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(4)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(8)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(9)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(11)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(12)) );
        //
        $oppositeSet = $integerRangeSet->oppositeSet();
        $this->assertTrue( $oppositeSet->has($this->createElement(-1000)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(-10)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(0)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(1)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(3)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(4)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(8)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(9)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(11)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(12)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(100)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(1000)) );

        // 0 1 2 3 4 5> 6 7 8 9 10 11 12 13  14 15
        // 0 1 2 3 4 5 6 7 8 <9 10> 11 12 13 14 15
        // 0 1 2 3 4 5 6 7 8  9 10 11 12 13 <14 15
        $integerRangeSet = $this->createRangeSet();
        $integerRangeSet->applyUnion($this->createRange($this->createElement(null), $this->createElement(5)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(9), $this->createElement(10)));
        $integerRangeSet->applyUnion($this->createRange($this->createElement(14), $this->createElement(null)));
        $this->assertTrue( $integerRangeSet->has($this->createElement(3)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(4)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(5)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(6)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(8)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(9)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(10)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(11)) );
        $this->assertFalse( $integerRangeSet->has($this->createElement(13)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(14)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(15)) );
        $this->assertTrue( $integerRangeSet->has($this->createElement(16)) );
        //
        $oppositeSet = $integerRangeSet->oppositeSet();
        $this->assertFalse( $oppositeSet->has($this->createElement(5)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(6)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(8)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(9)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(10)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(11)) );
        $this->assertTrue( $oppositeSet->has($this->createElement(13)) );
        $this->assertFalse( $oppositeSet->has($this->createElement(14)) );
    }

    private function createRangeSet(): RangeSet
    {
        return $this->factory->createRangeSet();
    }

    private function createRange(ElementCalculable $start, ElementCalculable $end): Range
    {
        return $this->factory->createRange($start, $end);
    }

    private function createElement($value): ElementCalculable
    {
        return $this->factory->createElement($value);
    }
}
