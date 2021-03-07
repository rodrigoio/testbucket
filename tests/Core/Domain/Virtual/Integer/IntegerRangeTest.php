<?php
namespace TestBucket\Test\Core\Domain\Virtual\Integer;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Domain\Virtual\Contracts\Range;
use TestBucket\Core\Domain\Virtual\Contracts\ElementCalculable;
use TestBucket\Core\Domain\Virtual\Integer\IntegerAbstractFactory;
use TestBucket\Core\Domain\Virtual\Integer\Precision\UnitPrecision;
use InvalidArgumentException;

/**
 * @group virtual_integer_range
 * @group virtual_integer
 * @group virtual
 */
class IntegerRangeTest extends TestCase
{
    /** @var IntegerAbstractFactory */
    private $factory;

    public function setUp()
    {
        $this->factory = new IntegerAbstractFactory();
    }

    public function testRangesAreEquals()
    {
        $rangeA = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(15));
        $rangeB = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(15));
        $this->assertTrue( $rangeA->equals($rangeB) );
    }

    public function testIfEndIsAlwaysMajorThanStart()
    {
        $range = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(15));
        $this->assertEquals($this->factory->createElement(9), $range->getStartValue());
        $this->assertEquals($this->factory->createElement(15), $range->getEndValue());

        $this->expectException(InvalidArgumentException::class);
        $this->getIntegerRange($this->factory->createElement(100), $this->factory->createElement(0));
    }

    public function testHasElement()
    {
        //--------------------------------------------------------------------
        // Regular cases
        //--------------------------------------------------------------------
        // <1 2> 3 4  5  6 7 8 9
        // 1  2  3 4 <5> 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(2));
        $this->assertFalse( $rangeA->has($this->factory->createElement(5)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        //  1  2 <3 4> 5 6 7 8 9
        // <1> 2  3 4  5 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(3), $this->factory->createElement(4));
        $this->assertFalse( $rangeA->has($this->factory->createElement(1)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 <2 3 4 5 6 7 8> 9
        // 1 2 3 4 5 <6> 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(2), $this->factory->createElement(8));
        $this->assertTrue( $rangeA->has($this->factory->createElement(6)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 <2 3 4 5 6 7 8> 9
        // 1 <2> 3 4 5 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(2), $this->factory->createElement(8));
        $this->assertTrue( $rangeA->has($this->factory->createElement(2)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 <2 3 4 5 6 7 8> 9
        // 1 2 3 4 5 6 7 <8> 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(2), $this->factory->createElement(8));
        $this->assertTrue( $rangeA->has($this->factory->createElement(8)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 <2 3 4 5 6 7 8> 9
        // 1  2 3 4 5 6 7 8 <9>
        $rangeA = $this->getIntegerRange($this->factory->createElement(2), $this->factory->createElement(8));
        $this->assertFalse( $rangeA->has($this->factory->createElement(9)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        //  1 <2 3 4 5 6 7 8> 9
        // <1> 2 3 4 5 6 7 8  9
        $rangeA = $this->getIntegerRange($this->factory->createElement(2), $this->factory->createElement(8));
        $this->assertFalse( $rangeA->has($this->factory->createElement(1)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        //--------------------------------------------------------------------
        // Infinity cases
        //--------------------------------------------------------------------
        // - - - - >< - - - -
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $this->assertTrue( $rangeA->has($this->factory->createInfinityElement()) );
        $this->assertTrue( $rangeA->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeA->has($this->factory->createElement(10000)) );
        $this->assertTrue( $rangeA->has($this->factory->createElement(-10000)) );

        // 1 2 3 4> 5 6 7 8  9
        // 1 2 3 4 5 6 7 <8> 9
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(4));
        $this->assertFalse( $rangeA->has($this->factory->createElement(8)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1  2  3 4> 5 6 7 8 9
        // 1 <2> 3 4  5 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(4));
        $this->assertTrue( $rangeA->has($this->factory->createElement(2)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1  2  3 4 <5 6 7 8 9
        // 1 <2> 3 4  5 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(5), $this->factory->createInfinityElement());
        $this->assertFalse( $rangeA->has($this->factory->createElement(2)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 2 3 4 <5 6  7  8 9
        // 1 2 3 4  5 6 <7> 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(5), $this->factory->createInfinityElement());
        $this->assertTrue( $rangeA->has($this->factory->createElement(7)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 2 3  4 <5 6 7 8 9
        // 1 2 3 <4> 5 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createElement(5), $this->factory->createInfinityElement());
        $this->assertFalse( $rangeA->has($this->factory->createElement(4)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );

        // 1 2 3 4> 5  6 7 8 9
        // 1 2 3 4 <5> 6 7 8 9
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(4));
        $this->assertFalse( $rangeA->has($this->factory->createElement(5)) );
        $this->assertFalse( $rangeA->has($this->factory->createInfinityElement()) );
    }

    public function testDomainRelation()
    {
        //--------------------------------------------------------------------
        // Regular ranges
        //--------------------------------------------------------------------
        //startsWithLocalDomainEndsWithOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(10), $this->factory->createElement(30));
        $rangeB = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(40));
        //
        $this->assertTrue( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //startsWithOuterDomainEndsWithLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(40));
        $rangeB = $this->getIntegerRange($this->factory->createElement(10), $this->factory->createElement(30));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertTrue( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(40));
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(100));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createElement(40), $this->factory->createElement(50));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainTouchesOuterDomainFromTheLeft
        $rangeA = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createElement(101), $this->factory->createElement(150));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainTouchesOuterDomainFromTheRight
        $rangeA = $this->getIntegerRange($this->factory->createElement(200), $this->factory->createElement(300));
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(199));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertTrue( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //--------------------------------------------------------------------
        // test with infinity ranges
        //--------------------------------------------------------------------
        //startsWithLocalDomainEndsWithOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(30));
        $rangeB = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createInfinityElement());
        // 0 10  20 30> 40 50
        // 0 10 <20 30  40 50
        $this->assertTrue( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //startsWithOuterDomainEndsWithLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(30));
        // 0 10 <20 30  40 50
        // 0 10  20 30> 40 50
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertTrue( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(50));
        $rangeB = $this->getIntegerRange($this->factory->createElement(10), $this->factory->createInfinityElement());
        // 0  10 <20 30 40 50> 100 200
        // 0 <10  20 30 40 50  100 200
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(50));
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(100));
        // 0 10 <20 30 40 50> 100
        // 0 10  20 30 40 50  100>
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        // <0 10 20 30 40 50 100>
        //          ><
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        // 0 10 20 30 40 50 100>
        //          ><
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //outerDomainContainsLocalDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        // <0 10 20 30 40 50
        //         ><
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createElement(10), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(50));
        // 0 <10  20 30 40 50  100 200
        // 0  10 <20 30 40 50> 100 200
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createElement(20), $this->factory->createElement(50));
        // 0 10  20 30 40 50  100>
        // 0 10 <20 30 40 50> 100
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(100));
        //          ><
        // <0 10 20 30 40 50 100>
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(100));
        //          ><
        // 0 10 20 30 40 50 100>
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainContainsOuterDomain
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createInfinityElement());
        //         ><
        // <0 10 20 30 40 50
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainTouchesOuterDomainFromTheLeft
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(100));
        $rangeB = $this->getIntegerRange($this->factory->createElement(101), $this->factory->createInfinityElement());
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertTrue( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );

        //localDomainTouchesOuterDomainFromTheRight
        $rangeA = $this->getIntegerRange($this->factory->createElement(200), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(199));
        //
        $this->assertFalse( $rangeA->startsWithLocalDomainEndsWithOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->startsWithOuterDomainEndsWithLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->outerDomainContainsLocalDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainContainsOuterDomain($rangeB) );
        $this->assertFalse( $rangeA->localDomainTouchesOuterDomainFromTheLeft($rangeB) );
        $this->assertTrue( $rangeA->localDomainTouchesOuterDomainFromTheRight($rangeB) );
    }

    public function testStartAndEndValues()
    {
        $range = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(15));

        $this->assertEquals($this->factory->createElement(9), $range->getStartValue());
        $this->assertEquals($this->factory->createElement(15), $range->getEndValue());

        // 8 <9 10 14 15> 16
        $this->assertFalse( $range->has($this->factory->createElement(8)) );
        $this->assertTrue( $range->has($this->factory->createElement(9)) );
        $this->assertTrue( $range->has($this->factory->createElement(10)) );
        $this->assertTrue( $range->has($this->factory->createElement(14)) );
        $this->assertTrue( $range->has($this->factory->createElement(15)) );
        $this->assertFalse( $range->has($this->factory->createElement(16)) );
    }

    public function testFromIntegerToInfinityRange()
    {
        $range = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createInfinityElement());

        // -99 0 1 8 <9 16 1000000<
        $this->assertFalse( $range->has($this->factory->createElement(-99)) );
        $this->assertFalse( $range->has($this->factory->createElement(0)) );
        $this->assertFalse( $range->has($this->factory->createElement(1)) );
        $this->assertFalse( $range->has($this->factory->createElement(8)) );
        $this->assertTrue( $range->has($this->factory->createElement(9)) );
        $this->assertTrue( $range->has($this->factory->createElement(16)) );
        $this->assertTrue( $range->has($this->factory->createElement(1000000)) );
    }

    public function testFromInfinityToInterger()
    {
        $range = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(9));

        // >-1 1 0 8 9> 10 16
        $this->assertTrue( $range->has($this->factory->createElement(-1)) );
        $this->assertTrue( $range->has($this->factory->createElement(1)) );
        $this->assertTrue( $range->has($this->factory->createElement(0)) );
        $this->assertTrue( $range->has($this->factory->createElement(8)) );
        $this->assertTrue( $range->has($this->factory->createElement(9)) );
        $this->assertFalse( $range->has($this->factory->createElement(10)) );
        $this->assertFalse( $range->has($this->factory->createElement(16)) );
    }

    public function testFromInfinityToInfinity()
    {
        $range = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());

        // >-1000 -100 -10 -1 0 1 10 100 1000<
        $this->assertTrue( $range->has($this->factory->createElement(-1000)) );
        $this->assertTrue( $range->has($this->factory->createElement(-100)) );
        $this->assertTrue( $range->has($this->factory->createElement(-10)) );
        $this->assertTrue( $range->has($this->factory->createElement(-1)) );
        $this->assertTrue( $range->has($this->factory->createElement(0)) );
        $this->assertTrue( $range->has($this->factory->createElement(1)) );
        $this->assertTrue( $range->has($this->factory->createElement(10)) );
        $this->assertTrue( $range->has($this->factory->createElement(100)) );
        $this->assertTrue( $range->has($this->factory->createElement(1000)) );
    }

    public function testUnionDomain()
    {
        // Starts with rangeA, ends with rangeB
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(9));
        $rangeB = $this->getIntegerRange($this->factory->createElement(7), $this->factory->createElement(15));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 7 8 9> 15 16
        // 0 1 <7 8 9 15> 16
        // 0 <1 7 8 9 15> 16
        $this->assertFalse( $rangeC->has( $this->factory->createElement(0) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(1) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(8) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(15) ) );
        $this->assertFalse( $rangeC->has( $this->factory->createElement(16) ) );

        // Starts with rangeB, ends with rangeA
        $rangeA = $this->getIntegerRange($this->factory->createElement(15), $this->factory->createElement(18));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(16));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // 0 1 <15 16 18> 19
        // 0 <1 15 16> 18 19
        // 0 <1 15 16 18> 19
        $this->assertFalse( $rangeC->has( $this->factory->createElement(0) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(1) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(18) ) );
        $this->assertFalse( $rangeC->has( $this->factory->createElement(19) ) );

        // RangeA covers rangeB
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(20));
        $rangeB = $this->getIntegerRange($this->factory->createElement(5), $this->factory->createElement(17));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 5 17 20> 21
        // 0 1 <5 17> 20 21
        // 0 <1 5 17 20> 21
        $this->assertFalse( $rangeC->has( $this->factory->createElement(0) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(1) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(20) ) );
        $this->assertFalse( $rangeC->has( $this->factory->createElement(21) ) );

        // RangeB covers rangeA
        $rangeA = $this->getIntegerRange($this->factory->createElement(18), $this->factory->createElement(26));
        $rangeB = $this->getIntegerRange($this->factory->createElement(-92), $this->factory->createElement(57));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // -92 0 1 <18 26> 57
        // <-92 0 1 18 26 57>
        // <-92 0 1 18 26 57>
        $this->assertFalse( $rangeC->has( $this->factory->createElement(-93) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(-92) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(57) ) );
        $this->assertFalse( $rangeC->has( $this->factory->createElement(58) ) );

        // Both ranges are equals
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(10));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(10));
        $this->assertTrue( $rangeB->reaches($rangeA) , 'rangeB reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 10> 11
        // 0 <1 10> 11
        // 0 <1 10> 11
        $this->assertFalse( $rangeC->has( $this->factory->createElement(0) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(1) ) );
        $this->assertTrue( $rangeC->has( $this->factory->createElement(10) ) );
        $this->assertFalse( $rangeC->has( $this->factory->createElement(11) ) );

        // Ranges that never meet each other, result in a composite domain
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(10));
        $rangeB = $this->getIntegerRange($this->factory->createElement(18), $this->factory->createElement(22));
        $this->assertFalse( $rangeB->reaches($rangeA) , 'rangeB dont reaches rangeA');
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);
        $rangeD = $resultList->get(1);

        // 0 <1 10> 18 22 23
        // 0 1 10 <18 22> 23
        // 0 <1 10> <18 22> 23
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(10)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(11)) );
        //
        $this->assertFalse( $rangeD->has($this->factory->createElement(17)) );
        $this->assertTrue( $rangeD->has($this->factory->createElement(18)) );
        $this->assertTrue( $rangeD->has($this->factory->createElement(22)) );
        $this->assertFalse( $rangeD->has($this->factory->createElement(23)) );

        //--------------------------------------------------------------------------
        // (( Infinity Tests ))
        //--------------------------------------------------------------------------
        // infinity over range
        //       > <
        // 0 <1 2 3> 4 5 6 7
        //       > <
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(3));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // range over infinity
        // 0 <1 2 3 4 5 6> 7
        //        > <
        //        > <
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(6));
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from left with range (precision cases)
        // 0 1 2 3> 4 5 6 7
        // 0 1 2 3 <4 5 6 7>
        // 0 1 2 3  4 5 6 7>
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createElement(7));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(7, $resultRange->getEndValue()->getValue());

        // infinity from left with infinity (precision cases)
        // 0 1 2 3> 4 5 6 7
        // 0 1 2 3 <4 5 6 7
        //        ><
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from right with range (precision cases)
        //  0 1 2 3 <4 5 6 7
        // <0 1 2 3> 4 5 6 7
        // <0
        $rangeA = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(3));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(0, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from right with infinity (precision cases)
        // 0 1 2 3 <4 5 6 7
        // 0 1 2 3> 4 5 6 7
        //        ><
        $rangeA = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from left with range (cross cases)
        // 0 1 2  3> 4 5 6 7
        // 0 1 2 <3  4 5 6 7>
        // 0 1 2  3  4 5 6 7>
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(3), $this->factory->createElement(7));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(7, $resultRange->getEndValue()->getValue());

        // infinity from left with infinity (cross cases)
        // 0 1 2  3> 4 5 6 7
        // 0 1 2 <3  4 5 6 7
        //        ><
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(3), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(null, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from right with range (cross cases)
        //  0 1 2 3 <4  5 6 7
        // <0 1 2 3  4> 5 6 7
        // <0 1 2 3  4  5 6 7
        $rangeA = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(4));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(1, $resultList->count());
        $resultRange = $resultList->get(0);
        $this->assertEquals(0, $resultRange->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange->getEndValue()->getValue());

        // infinity from left with range (non-cross cases)
        // 0 1 2 3> 4 5  6 7
        // 0 1 2 3  4 5 <6 7>
        // 0 1 2 3> 4 5 <6 7>
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(6), $this->factory->createElement(7));
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(2, $resultList->count());
        $resultRange1 = $resultList->get(0);
        $this->assertEquals(null, $resultRange1->getStartValue()->getValue());
        $this->assertEquals(3, $resultRange1->getEndValue()->getValue());
        $resultRange2 = $resultList->get(1);
        $this->assertEquals(6, $resultRange2->getStartValue()->getValue());
        $this->assertEquals(7, $resultRange2->getEndValue()->getValue());

        // infinity from left with infinity (non-cross cases)
        // 0 1 2 3> 4 5  6 7
        // 0 1 2 3  4 5 <6 7
        // 0 1 2 3> 4 5 <6 7
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(3));
        $rangeB = $this->getIntegerRange($this->factory->createElement(6), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(2, $resultList->count());
        $resultRange1 = $resultList->get(0);
        $this->assertEquals(null, $resultRange1->getStartValue()->getValue());
        $this->assertEquals(3, $resultRange1->getEndValue()->getValue());
        $resultRange2 = $resultList->get(1);
        $this->assertEquals(6, $resultRange2->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange2->getEndValue()->getValue());

        // infinity from right with range (non-cross cases)
        //  0 1 2  3 <4 5 6 7
        // <0 1 2> 3  4 5 6 7
        // <0 1 2> 3 <4 5 6 7
        $rangeA = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(2));
        $rangeB = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(2, $resultList->count());
        $resultRange1 = $resultList->get(0);
        $this->assertEquals(0, $resultRange1->getStartValue()->getValue());
        $this->assertEquals(2, $resultRange1->getEndValue()->getValue());
        $resultRange2 = $resultList->get(1);
        $this->assertEquals(4, $resultRange2->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange2->getEndValue()->getValue());

        // infinity from right with infinity (non-cross cases)
        // 0 1  2 3 <4 5 6 7
        // 0 1> 2 3  4 5 6 7
        // 0 1> 2 3 <4 5 6 7
        $rangeA = $this->getIntegerRange($this->factory->createInfinityElement(), $this->factory->createElement(1));
        $rangeB = $this->getIntegerRange($this->factory->createElement(4), $this->factory->createInfinityElement());
        $resultList = $rangeA->union($rangeB);
        $this->assertEquals(2, $resultList->count());
        $resultRange1 = $resultList->get(0);
        $this->assertEquals(null, $resultRange1->getStartValue()->getValue());
        $this->assertEquals(1, $resultRange1->getEndValue()->getValue());
        $resultRange2 = $resultList->get(1);
        $this->assertEquals(4, $resultRange2->getStartValue()->getValue());
        $this->assertEquals(null, $resultRange2->getEndValue()->getValue());
    }

    public function testSubtractDomain()
    {
        // Starts with rangeA, and rangeB removes a tail of rangeA
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(9));
        $rangeB = $this->getIntegerRange($this->factory->createElement(7), $this->factory->createElement(15));
        $resultList = $rangeA->difference($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 6 7 9> 15 16
        // 0 1 6 <7 9 15> 16
        // 0 <1 6> 7 9 15 16
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(4)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(6)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(7)) );

        // Starts with rangeB, and rangeB removes the first part of rangeA
        $rangeA = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(26));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(12));
        $resultList = $rangeA->difference($rangeB);
        $rangeC = $resultList->get(0);

        // 0 1 <9 12 13 26> 27
        // 0 <1 9 12> 13 26 27
        // 0 1 9 12 <13 26> 27
        $this->assertFalse( $rangeC->has($this->factory->createElement(12)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(13)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(17)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(26)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(27)) );

        // RangeB covers all rangeA, and the result is an empty domain.
        $rangeA = $this->getIntegerRange($this->factory->createElement(5), $this->factory->createElement(8));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(12));
        $resultList = $rangeA->difference($rangeB);

        // 0 1 4 <5 7 8> 11 12 13
        // 0 <1 4 5 7 8 11 12> 13
        // 0 1 4 5 7 8 11 12 13
        $this->assertEquals(0, $resultList->count());


        // RangeA and rangeB are the same domain, and the result is an empty domain
        $rangeA = $this->getIntegerRange($this->factory->createElement(216), $this->factory->createElement(300));
        $rangeB = $this->getIntegerRange($this->factory->createElement(216), $this->factory->createElement(300));
        $resultList = $rangeA->difference($rangeB);

        // 215 <216 300> 301
        // 215 <216 300> 301
        // 215 216 300 301
        $this->assertEquals(0, $resultList->count());


        // RangeA covers all rangeB, and rangeB splits rangeA resulting a composite domain
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(30));
        $rangeB = $this->getIntegerRange($this->factory->createElement(12), $this->factory->createElement(21));
        $resultList = $rangeA->difference($rangeB);
        $rangeC = $resultList->get(0);
        $rangeD = $resultList->get(1);

        // 0 <1 11 12 21 22 30> 31
        // 0 1 11 <12 21> 22 30 31
        // 0 <1 11> 12 21 <22 30> 31
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(11)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(12)) );
        //
        $this->assertFalse( $rangeD->has($this->factory->createElement(21)) );
        $this->assertTrue( $rangeD->has($this->factory->createElement(22)) );
        $this->assertTrue( $rangeD->has($this->factory->createElement(30)) );
        $this->assertFalse( $rangeD->has($this->factory->createElement(31)) );


        // rangeA and rangeB never meet each other, so the result is rangeA
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(22));
        $rangeB = $this->getIntegerRange($this->factory->createElement(56), $this->factory->createElement(198));
        $resultList = $rangeA->difference($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 22> 23 56 198
        // 0 1 22 23 <56 198>
        // 0 <1 22> 23 56 198
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(22)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(23)) );
    }

    public function testPrecisionOnAddOperation()
    {
        $rangeA = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(8));
        $rangeB = $this->getIntegerRange($this->factory->createElement(9), $this->factory->createElement(22));
        $this->assertTrue( $rangeA->reaches($rangeB) );
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);
        //
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(22)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(23)) );

        $rangeA = $this->getIntegerRange($this->factory->createElement(25), $this->factory->createElement(32));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1), $this->factory->createElement(24));
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);
        //
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(32)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(33)) );

        $rangeA = $this->getIntegerRange($this->factory->createElement(10, new UnitPrecision(2)), $this->factory->createElement(22, new UnitPrecision(2)));
        $rangeB = $this->getIntegerRange($this->factory->createElement(1, new UnitPrecision(2)), $this->factory->createElement(8, new UnitPrecision(2)));

        $this->assertTrue( $rangeA->reaches($rangeB) );
        $resultList = $rangeA->union($rangeB);
        $rangeC = $resultList->get(0);

        // 0 <1 8> 9 10 22 23
        // 0 1 8 9 <10 22> 23
        // 0 <1 8 9 10 22> 23
        $this->assertFalse( $rangeC->has($this->factory->createElement(0)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(1)) );
        $this->assertTrue( $rangeC->has($this->factory->createElement(22)) );
        $this->assertFalse( $rangeC->has($this->factory->createElement(23)) );
    }

    public function testARangeReachesAnother()
    {
        $rangeA = $this->getIntegerRange($this->factory->createElement(10), $this->factory->createElement(20));

        // reaches rangeA
        $rangeB = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(11));
        $rangeC = $this->getIntegerRange($this->factory->createElement(19), $this->factory->createElement(30));
        $this->assertTrue( $rangeB->reaches($rangeA) );
        $this->assertTrue( $rangeC->reaches($rangeA) );

        // don't reaches rangeA
        $rangeM = $this->getIntegerRange($this->factory->createElement(0), $this->factory->createElement(8));
        $rangeN = $this->getIntegerRange($this->factory->createElement(22), $this->factory->createElement(30));
        $this->assertFalse( $rangeM->reaches($rangeA) );
        $this->assertFalse( $rangeN->reaches($rangeA) );
    }

    private function getIntegerRange(ElementCalculable $start, ElementCalculable $end): Range
    {
        return $this->factory->createRange($start, $end);
    }
}
