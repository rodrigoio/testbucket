<?php
namespace App\Test\Core\Range;

use App\Core\Range\IntegerRange;
use App\Core\Range\IntegerRangeGenerator;
use PHPUnit\Framework\TestCase;

/**
 * @group Range
 */
class IntegerRangeGeneratorTest extends TestCase
{
    public function testGenerationWithRules()
    {
        $range = new IntegerRange(9, 15);

        $generator = new IntegerRangeGenerator($range);

        //TODO - still working on it...
        $results = $generator->generate();
        print_r($results);

        $this->assertEquals(true, true);
    }

    public function testGenerationWithRandomicStragety()
    {
        $this->assertEquals(true, true);
    }
}