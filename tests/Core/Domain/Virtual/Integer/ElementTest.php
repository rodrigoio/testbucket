<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;

/**
 * @group Integer
 */
class ElementTest extends TestCase
{
    public function testElementAgainstElement()
    {
        $element1 = new Element(10);
        $element2 = new Element(25);
        $element3 = new Element(10);

        $this->assertFalse( $element1->equals($element2) );
        $this->assertTrue( $element1->equals($element3) );
    }

    public function testIncrementAndDecrement()
    {
        $element1 = new Element(10);
        $element2 = new Element(9);
        $element3 = new Element(11);

        $before = $element1->prev();
        $after = $element1->next();

        $this->assertTrue( $element2->equals($before) );
        $this->assertTrue( $element3->equals($after) );
        $this->assertTrue( $element1->equals(new Element(10)) );
    }

    public function testInvalidPrecision()
    {
        try {
            $element1 = new Element(10);
            $element1->setPrecision('ABC');
        } catch (\Exception $e) {
            $this->assertEquals('Precision must be int', $e->getMessage());
        }
    }
}
