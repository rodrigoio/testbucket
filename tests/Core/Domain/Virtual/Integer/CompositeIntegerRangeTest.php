<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;

/**
 * @group integer_rangex
 */
class CompositeIntegerRangeTest extends TestCase
{
    public function testCompositionWithRangeCombination()
    {
        // non-crossing cases
        $composite = new CompositeIntegerRange(new Element(-10), new Element(-5));

        $rangeA = new IntegerRange(new Element(0), new Element(5));
        $composite = $composite->add($rangeA);

        $rangeB = new IntegerRange(new Element(10), new Element(15));
        $composite = $composite->add($rangeB);

        $rangeC = new IntegerRange(new Element(20), new Element(25));
        $composite = $composite->add($rangeC);

        $rangeD = new IntegerRange(new Element(26), new Element(30));
        $composite = $composite->add($rangeD);

        $composite->getStartValue();

        $this->assertInstanceOf(Element::class, $composite->getStartValue());
        $this->assertEquals(-10, $composite->getStartValue()->getValue() );
        $this->assertEquals(30, $composite->getEndValue()->getValue() );
        //$this->assertEquals(5, $composite->countPartitions() );

        $this->assertFalse( $composite->has(new Element(-11)) );
        $this->assertTrue( $composite->has(new Element(-10)) );
        $this->assertTrue( $composite->has(new Element(-5)) );
        $this->assertFalse( $composite->has(new Element(-4)) );

        $this->assertFalse( $composite->has(new Element(-1)) );
        $this->assertTrue( $composite->has(new Element(0)) );
        $this->assertTrue( $composite->has(new Element(5)) );
        $this->assertFalse( $composite->has(new Element(6)) );

        $this->assertFalse( $composite->has(new Element(9)) );
        $this->assertTrue( $composite->has(new Element(10)) );
        $this->assertTrue( $composite->has(new Element(15)) );
        $this->assertFalse( $composite->has(new Element(16)) );

        $this->assertFalse( $composite->has(new Element(19)) );
        $this->assertTrue( $composite->has(new Element(20)) );
        $this->assertTrue( $composite->has(new Element(25)) );
        $this->assertTrue( $composite->has(new Element(26)) );
        $this->assertTrue( $composite->has(new Element(30)) );
        $this->assertFalse( $composite->has(new Element(31)) );

        // crossing cases
        $composite = new CompositeIntegerRange(new Element(1), new Element(16));

        $rangeA = new IntegerRange(new Element(15), new Element(20));
        $composite = $composite->add($rangeA);

        $rangeB = new IntegerRange(new Element(19), new Element(25));
        $composite = $composite->add($rangeB);

        $rangeC = new IntegerRange(new Element(11), new Element(18));
        $composite = $composite->add($rangeC);

        $this->assertEquals(1, $composite->getStartValue()->getValue() );
        $this->assertEquals(25, $composite->getEndValue()->getValue() );
        //$this->assertEquals(1, $composite->countPartitions() );
    }

    public function testCompositionWithRangeAndComposition()
    {
        // crossing cases
        $compositeA = new CompositeIntegerRange(new Element(1), new Element(15));
        $compositeB = new CompositeIntegerRange(new Element(10), new Element(30));
        $composite = $compositeA->add($compositeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        //$this->assertEquals(1, $composite->countPartitions());

        // non-crossing cases
        $compositeA = new CompositeIntegerRange(new Element(1), new Element(10));
        $compositeB = new CompositeIntegerRange(new Element(15), new Element(30));
        $composite = $compositeA->add($compositeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        //$this->assertEquals(2, $composite->countPartitions());

        // mergin non-crossed domains
        $rangeB = new IntegerRange(new Element(9), new Element(16));
        $composite = $composite->add($rangeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        //$this->assertEquals(1, $composite->countPartitions());
    }

    public function testSubtractCompositionWithRange()
    {
        // crop from left
        $composite = new CompositeIntegerRange(new Element(0), new Element(20));
        $rangeA = new IntegerRange(new Element(10), new Element(20));
        $composite = $composite->subtract($rangeA);
        //
        $this->assertEquals(0, $composite->getStartValue()->getValue() );
        $this->assertEquals(9, $composite->getEndValue()->getValue() );

        // crop from right
        $composite = new CompositeIntegerRange(new Element(10), new Element(20));
        $rangeA = new IntegerRange(new Element(0), new Element(10));
        $composite = $composite->subtract($rangeA);
        //
        $this->assertEquals(11, $composite->getStartValue()->getValue() );
        $this->assertEquals(20, $composite->getEndValue()->getValue() );

        // crop from middle
        $composite = new CompositeIntegerRange(new Element(0), new Element(20));
        $rangeA = new IntegerRange(new Element(11), new Element(14));
        $composite = $composite->subtract($rangeA);

        $this->assertEquals(0, $composite->getStartValue()->getValue() );
        $this->assertEquals(20, $composite->getEndValue()->getValue() );

        $this->assertTrue( $composite->has(new Element(0)) );
        $this->assertTrue( $composite->has(new Element(10)) );
        $this->assertFalse( $composite->has(new Element(11)) );
        $this->assertFalse( $composite->has(new Element(12)) );
        $this->assertFalse( $composite->has(new Element(13)) );
        $this->assertFalse( $composite->has(new Element(14)) );
        $this->assertTrue( $composite->has(new Element(15)) );
        $this->assertTrue( $composite->has(new Element(20)) );

        // crop composition TODO - review composition subtraction.
        $compositeA = new CompositeIntegerRange(new Element(0), new Element(1000));
        $compositeB = new CompositeIntegerRange(new Element(900), new Element(999));
        $compositeC = new CompositeIntegerRange(new Element(100), new Element(105));
        //$compositeA = $compositeA->subtract($compositeB);
        //$compositeA = $compositeA->subtract($compositeC);

        //$this->assertTrue( $compositeA->has(new Element(0)) );
        //$this->assertTrue( $compositeA->has(new Element(99)) );

        //$this->assertTrue( $compositeA->has(new Element(0)) );
        //$this->assertTrue( $compositeA->has(new Element(99)) );
    }

//    public function testNegativeDomain()
//    {
//        //TODO - implement negative domain
//    }
}
