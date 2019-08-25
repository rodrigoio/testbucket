<?php
namespace App\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use App\Core\Domain\Virtual\Integer\Element;
use App\Core\Domain\Virtual\Integer\EmptyDomain;
use App\Core\Domain\Virtual\Integer\IntegerRange;

/**
 * @group Integer
 */
class EmptyDomainTest extends TestCase
{
    public function testTheConstantBehaviorOfEmptyDomain()
    {
        $range = new IntegerRange(new Element(1), new Element(10));
        $domain = new EmptyDomain();

        $this->assertFalse( $domain->has(new Element(1)) );
        $this->assertEquals(new Element(), $domain->getStartValue());
        $this->assertEquals(new Element(), $domain->getEndValue());

        $domainWithoutRange = $domain->subtract($range);
        $this->assertFalse( $domainWithoutRange->has(new Element(1)) );
        $this->assertEquals(new Element(), $domainWithoutRange->getStartValue());
        $this->assertEquals(new Element(), $domainWithoutRange->getEndValue());

        // emptyDomain + RangeX = RangeX
        $domainWithRange = $domain->add($range);

        $this->assertFalse( $domainWithRange->has(new Element(0)) );
        $this->assertTrue( $domainWithRange->has(new Element(1)) );
        $this->assertTrue( $domainWithRange->has(new Element(10)) );
        $this->assertFalse( $domainWithRange->has(new Element(11)) );

        $this->assertEquals(1, $domainWithRange->getStartValue()->getValue());
        $this->assertEquals(10, $domainWithRange->getEndValue()->getValue());
    }
}