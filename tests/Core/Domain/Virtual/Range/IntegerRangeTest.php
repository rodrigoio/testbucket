<?php
namespace App\Test\Core\Domain\Virtual\Range;

use PHPUnit\Framework\TestCase;
use App\Core\DataSource\ConcreteDataSource;
use App\Core\Domain\Virtual\Range\Number\IntegerRange;

/**
 * @group IntegerRange
 */
class IntegerRangeTest extends TestCase
{
    public function testInclusiveStartAndEndValues()
    {
        $range = new IntegerRange(new ConcreteDataSource([9, 15]));

        $this->assertFalse( $range->has(8) );
        $this->assertTrue( $range->has(9) );
        $this->assertTrue( $range->has(10) );
        $this->assertTrue( $range->has(14) );
        $this->assertTrue( $range->has(15) );
        $this->assertFalse( $range->has(16) );
    }

    public function testInvalidRangeStartValue()
    {
        try {
            $range = new IntegerRange(new ConcreteDataSource(['10', 9]));
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Use only integer values', $e->getMessage());
        }
    }

    public function testInvalidRangeEndValue()
    {
        try {
            $range = new IntegerRange(new ConcreteDataSource([10, []]));
        } catch (\InvalidArgumentException $e) {
            $this->assertEquals('Use only integer values', $e->getMessage());
        }
    }
}
