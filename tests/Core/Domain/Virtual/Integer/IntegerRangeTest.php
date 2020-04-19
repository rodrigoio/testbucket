<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;

/**
 * @group integer_range
 */
class IntegerRangeTest extends TestCase
{
    public function testStartAndEndValues()
    {
        $range = new IntegerRange(new Element(9), new Element(15));

        $this->assertEquals(new Element(9), $range->getStartValue());
        $this->assertEquals(new Element(15), $range->getEndValue());
        $this->assertEquals(1, $range->countPartitions());

        // 8 <9 10 14 15> 16
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

        // -99 0 1 8 <9 16 1000000<
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

        // >-1 1 0 8 9> 10 16
        $this->assertTrue( $range->has(new Element(-1)) );
        $this->assertTrue( $range->has(new Element(1)) );
        $this->assertTrue( $range->has(new Element(0)) );
        $this->assertTrue( $range->has(new Element(8)) );
        $this->assertTrue( $range->has(new Element(9)) );
        $this->assertFalse( $range->has(new Element(10)) );
        $this->assertFalse( $range->has(new Element(16)) );
    }

    public function testFromInfinityToInfinity()
    {
        $range = new IntegerRange(new Element(), new Element());

        // >-1000 -100 -10 -1 0 1 10 100 1000<
        $this->assertTrue( $range->has(new Element(-1000)) );
        $this->assertTrue( $range->has(new Element(-100)) );
        $this->assertTrue( $range->has(new Element(-10)) );
        $this->assertTrue( $range->has(new Element(-1)) );
        $this->assertTrue( $range->has(new Element(0)) );
        $this->assertTrue( $range->has(new Element(1)) );
        $this->assertTrue( $range->has(new Element(10)) );
        $this->assertTrue( $range->has(new Element(100)) );
        $this->assertTrue( $range->has(new Element(1000)) );
    }

    public function testAddDomain()
    {
        // Starts with rangeA, ends with rangeB
        $rangeA = new IntegerRange(new Element(1), new Element(9));
        $rangeB = new IntegerRange(new Element(7), new Element(15));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // 0 <1 7 8 9> 15 16
        // 0 1 <7 8 9 15> 16
        // 0 <1 7 8 9 15> 16
        $this->assertFalse( $rangeC->has( new Element(0) ) );
        $this->assertTrue( $rangeC->has( new Element(1) ) );
        $this->assertTrue( $rangeC->has( new Element(8) ) );
        $this->assertTrue( $rangeC->has( new Element(15) ) );
        $this->assertFalse( $rangeC->has( new Element(16) ) );

        // Starts with rangeB, ends with rangeA
        $rangeA = new IntegerRange(new Element(15), new Element(18));
        $rangeB = new IntegerRange(new Element(1), new Element(16));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // 0 1 <15 16 18> 19
        // 0 <1 15 16> 18 19
        // 0 <1 15 16 18> 19
        $this->assertFalse( $rangeC->has( new Element(0) ) );
        $this->assertTrue( $rangeC->has( new Element(1) ) );
        $this->assertTrue( $rangeC->has( new Element(18) ) );
        $this->assertFalse( $rangeC->has( new Element(19) ) );

        // RangeA covers rangeB
        $rangeA = new IntegerRange(new Element(1), new Element(20));
        $rangeB = new IntegerRange(new Element(5), new Element(17));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // 0 <1 5 17 20> 21
        // 0 1 <5 17> 20 21
        // 0 <1 5 17 20> 21
        $this->assertFalse( $rangeC->has( new Element(0) ) );
        $this->assertTrue( $rangeC->has( new Element(1) ) );
        $this->assertTrue( $rangeC->has( new Element(20) ) );
        $this->assertFalse( $rangeC->has( new Element(21) ) );

        // RangeB covers rangeA
        $rangeA = new IntegerRange(new Element(18), new Element(26));
        $rangeB = new IntegerRange(new Element(-92), new Element(57));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // -92 0 1 <18 26> 57
        // <-92 0 1 18 26 57>
        // <-92 0 1 18 26 57>
        $this->assertFalse( $rangeC->has( new Element(-93) ) );
        $this->assertTrue( $rangeC->has( new Element(-92) ) );
        $this->assertTrue( $rangeC->has( new Element(57) ) );
        $this->assertFalse( $rangeC->has( new Element(58) ) );

        // Both ranges are equals
        $rangeA = new IntegerRange(new Element(1), new Element(10));
        $rangeB = new IntegerRange(new Element(1), new Element(10));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // 0 <1 10> 11
        // 0 <1 10> 11
        // 0 <1 10> 11
        $this->assertFalse( $rangeC->has( new Element(0) ) );
        $this->assertTrue( $rangeC->has( new Element(1) ) );
        $this->assertTrue( $rangeC->has( new Element(10) ) );
        $this->assertFalse( $rangeC->has( new Element(11) ) );

        // Ranges that never meet each other, result in a composite domain
        $rangeA = new IntegerRange(new Element(1), new Element(10));
        $rangeB = new IntegerRange(new Element(18), new Element(22));
        $this->assertFalse( $rangeB->reaches($rangeA) , 'rangeB dont reaches rangeA');
        $rangeC = $rangeA->add($rangeB);

        // 0 <1 10> 18 22 23
        // 0 1 10 <18 22> 23
        // 0 <1 10> <18 22> 23
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

    public function testSubtractDomain()
    {
        // Starts with rangeA, and rangeB removes a tail of rangeA
        $rangeA = new IntegerRange(new Element(1), new Element(9));
        $rangeB = new IntegerRange(new Element(7), new Element(15));
        $rangeC = $rangeA->subtract($rangeB);

        // 0 <1 6 7 9> 15 16
        // 0 1 6 <7 9 15> 16
        // 0 <1 6> 7 9 15 16
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(4)) );
        $this->assertTrue( $rangeC->has(new Element(6)) );
        $this->assertFalse( $rangeC->has(new Element(7)) );

        // Starts with rangeB, and rangeB removes the first part of rangeA
        $rangeA = new IntegerRange(new Element(9), new Element(26));
        $rangeB = new IntegerRange(new Element(1), new Element(12));
        $rangeC = $rangeA->subtract($rangeB);

        // 0 1 <9 12 13 26> 27
        // 0 <1 9 12> 13 26 27
        // 0 1 9 12 <13 26> 27
        $this->assertFalse( $rangeC->has(new Element(12)) );
        $this->assertTrue( $rangeC->has(new Element(13)) );
        $this->assertTrue( $rangeC->has(new Element(17)) );
        $this->assertTrue( $rangeC->has(new Element(26)) );
        $this->assertFalse( $rangeC->has(new Element(27)) );

        // RangeB covers all rangeA, and the result is an empty domain.
        $rangeA = new IntegerRange(new Element(5), new Element(8));
        $rangeB = new IntegerRange(new Element(1), new Element(12));
        $rangeC = $rangeA->subtract($rangeB);

        // 0 1 4 <5 7 8> 11 12 13
        // 0 <1 4 5 7 8 11 12> 13
        // 0 1 4 5 7 8 11 12 13
        $this->assertFalse( $rangeC->has(new Element(4)) );
        $this->assertFalse( $rangeC->has(new Element(5)) );
        $this->assertFalse( $rangeC->has(new Element(6)) );
        $this->assertFalse( $rangeC->has(new Element(8)) );
        $this->assertFalse( $rangeC->has(new Element(9)) );
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertFalse( $rangeC->has(new Element(1)) );
        $this->assertFalse( $rangeC->has(new Element(12)) );
        $this->assertFalse( $rangeC->has(new Element(13)) );

        // RangeA and rangeB are the same domain, and the result is an empty domain
        $rangeA = new IntegerRange(new Element(216), new Element(300));
        $rangeB = new IntegerRange(new Element(216), new Element(300));
        $rangeC = $rangeA->subtract($rangeB);

        // 215 <216 300> 301
        // 215 <216 300> 301
        // 215 216 300 301
        $this->assertFalse( $rangeC->has(new Element(215)) );
        $this->assertFalse( $rangeC->has(new Element(216)) );
        $this->assertFalse( $rangeC->has(new Element(300)) );
        $this->assertFalse( $rangeC->has(new Element(301)) );

        // RangeA covers all rangeB, and rangeB splits rangeA resulting a composite domain
        $rangeA = new IntegerRange(new Element(1), new Element(30));
        $rangeB = new IntegerRange(new Element(12), new Element(21));
        $rangeC = $rangeA->subtract($rangeB);
        $this->assertInstanceOf(CompositeIntegerRange::class, $rangeC);

        // 0 <1 11 12 21 22 30> 31
        // 0 1 11 <12 21> 22 30 31
        // 0 <1 11> 12 21 <22 30> 31
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(11)) );
        $this->assertFalse( $rangeC->has(new Element(12)) );
        //
        $this->assertFalse( $rangeC->has(new Element(21)) );
        $this->assertTrue( $rangeC->has(new Element(22)) );
        $this->assertTrue( $rangeC->has(new Element(30)) );
        $this->assertFalse( $rangeC->has(new Element(31)) );

        // RangeA and rangeB never meet each other, so the result is rangeA
        $rangeA = new IntegerRange(new Element(1), new Element(22));
        $rangeB = new IntegerRange(new Element(56), new Element(198));
        $rangeC = $rangeA->subtract($rangeB);

        // 0 <1 22> 23 56 198
        // 0 1 22 23 <56 198>
        // 0 <1 22> 23 56 198
        $this->assertInstanceOf(CompositeIntegerRange::class, $rangeC);
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(22)) );
        $this->assertFalse( $rangeC->has(new Element(23)) );
    }

    public function testPrecisionOnAddOperation()
    {
        $rangeA = new IntegerRange(new Element(1), new Element(8), 1);
        $rangeB = new IntegerRange(new Element(9), new Element(22), 1);
        $this->assertTrue( $rangeA->reaches($rangeB) );
        $rangeC = $rangeA->add($rangeB);
        //
        $this->assertEquals(1, $rangeC->countPartitions());
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(22)) );
        $this->assertFalse( $rangeC->has(new Element(23)) );

        $rangeA = new IntegerRange(new Element(25), new Element(32), 1);
        $rangeB = new IntegerRange(new Element(1), new Element(24), 1);
        $rangeC = $rangeA->add($rangeB);
        //
        $this->assertEquals(1, $rangeC->countPartitions());
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(32)) );
        $this->assertFalse( $rangeC->has(new Element(33)) );

        $rangeA = new IntegerRange(new Element(1), new Element(8), 2);
        $rangeB = new IntegerRange(new Element(10), new Element(22));
        $rangeC = $rangeA->add($rangeB);

        // 0 <1 8> 9 10 22 23
        // 0 1 8 9 <10 22> 23
        // 0 <1 8 9 10 22> 23
        $this->assertEquals(1, $rangeC->countPartitions());
        $this->assertFalse( $rangeC->has(new Element(0)) );
        $this->assertTrue( $rangeC->has(new Element(1)) );
        $this->assertTrue( $rangeC->has(new Element(22)) );
        $this->assertFalse( $rangeC->has(new Element(23)) );
    }

    public function testARangeReachesAnother()
    {
        $rangeA = new IntegerRange(new Element(10), new Element(20), 1);

        // reaches rangeA
        $rangeB = new IntegerRange(new Element(0), new Element(11), 1);
        $rangeC = new IntegerRange(new Element(19), new Element(30), 1);
        $this->assertTrue( $rangeB->reaches($rangeA) );
        $this->assertTrue( $rangeC->reaches($rangeA) );

        // don't reaches rangeA
        $rangeM = new IntegerRange(new Element(0), new Element(8), 1);
        $rangeN = new IntegerRange(new Element(22), new Element(30), 1);
        $this->assertFalse( $rangeM->reaches($rangeA) );
        $this->assertFalse( $rangeN->reaches($rangeA) );
    }
}
