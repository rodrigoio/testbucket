<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\IntegerRange;
use App\Core\Domain\Virtual\Integer\CompositeIntegerRange;

/**
 * @group Integer
 */
class CompositeIntegerRangeTest extends TestCase
{
    public function testCompositionWithRangeCombination()
    {
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
        $this->assertEquals(1, $composite->countPartitions() );


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

        $this->assertEquals(-10, $composite->getStartValue()->getValue() );
        $this->assertEquals(30, $composite->getEndValue()->getValue() );
        $this->assertEquals(4, $composite->countPartitions() );

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
    }

    public function testCompositionWithRangeAndComposition()
    {
        // crossing cases
        $compositeA = new CompositeIntegerRange(new Element(1), new Element(15));
        $compositeB = new CompositeIntegerRange(new Element(10), new Element(30));
        $composite = $compositeA->add($compositeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        $this->assertEquals(1, $composite->countPartitions());

        // non-crossing cases
        $compositeA = new CompositeIntegerRange(new Element(1), new Element(10));
        $compositeB = new CompositeIntegerRange(new Element(15), new Element(30));
        $composite = $compositeA->add($compositeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        $this->assertEquals(2, $composite->countPartitions());

        // mergin non-crossed domains
        $rangeB = new IntegerRange(new Element(9), new Element(16));
        $composite = $composite->add($rangeB);
        $this->assertEquals(1, $composite->getStartValue()->getValue());
        $this->assertEquals(30, $composite->getEndValue()->getValue());
        $this->assertEquals(1, $composite->countPartitions());
    }
}
