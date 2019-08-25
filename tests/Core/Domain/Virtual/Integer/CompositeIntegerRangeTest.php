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
    public function testCompositionWithOneRange()
    {
        $range = new IntegerRange( new Element(1), new Element(16) );

        $composite = new CompositeIntegerRange(new \ArrayObject([$range]));

        $this->assertFalse( $composite->has( new Element(0) ) );
        $this->assertTrue( $composite->has( new Element(1) ) );
        $this->assertTrue( $composite->has( new Element(9) ) );
        $this->assertTrue( $composite->has( new Element(11) ) );
        $this->assertTrue( $composite->has( new Element(16) ) );
        $this->assertFalse( $composite->has( new Element(17) ) );
    }

//    public function testCompositionWithOneUnity()
//    {
//        $unity = new Integer( new Element(5) );
//
//        $composed = new CompositeIntegerRange(new \ArrayObject([$unity]));
//
//        $this->assertFalse( $composed->has( new Element(4) ) );
//        $this->assertTrue( $composed->has( new Element(5) ) );
//        $this->assertFalse( $composed->has( new Element(6) ) );
//    }

    public function testMixedComposition()
    {
        $range = new IntegerRange( new Element(1), new Element(16) );
//        $unity = new Integer( new Element(56) );

        $parts = new \ArrayObject();
        $parts->append($range);
//        $parts->append($unity);

        $composite = new CompositeIntegerRange( $parts );

        $this->assertFalse( $composite->has( new Element(0) ) );
        $this->assertTrue( $composite->has( new Element(1) ) );
        $this->assertTrue( $composite->has( new Element(16) ) );
        $this->assertFalse( $composite->has( new Element(17) ) );

//        $this->assertFalse( $composite->has( new Element(55) ) );
//        $this->assertTrue( $composite->has( new Element(56) ) );
//        $this->assertFalse( $composite->has( new Element(57) ) );
    }
}
