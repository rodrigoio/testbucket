<?php
namespace App\Test\Core\Domain\Virtual\Range\Number;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\Integer;

/**
 * @group Integer
 */
class IntegerTest extends TestCase
{
    public function testAUniqueAndValidValue()
    {
        $unity = new Integer( new Element(5) );
        $this->assertTrue( $unity->has( new Element(5) ) );
    }

    public function testAUniqueAndInvalidValue()
    {
        $unity = new Integer( new Element(5) );
        $this->assertFalse( $unity->has( new Element(4) ) );
        $this->assertFalse( $unity->has( new Element(6) ) );
    }
}
