<?php
namespace App\Test\Core\Generator\Range;

use App\Core\Domain\Virtual\Range\Number\IntegerRange;
use App\Core\Generator\Range\IntegerRangeGenerator;
use App\Core\DataSource\ConcreteDataSource;
use PHPUnit\Framework\TestCase;

/**
 * @group Range
 */
class IntegerGeneratorTest extends TestCase
{
    public function testGenerationWithRules()
    {
        $range = new IntegerRange(new ConcreteDataSource([9, 15]));

        $generator = new IntegerRangeGenerator($range);

        $results = $generator->generate();

        foreach ($results as $case) {

            if ($case->isSuccess()) {

                $this->assertTrue($case->isSuccess());//TODO - remove after next review

                foreach ($case->getData() as $validInput) {
                    //TODO - must review the use of this Element interface through the domain - and result test cases.
                    // $this->assertEquals( $range->has($validInput) );
                }
            }
        }

    }
}
