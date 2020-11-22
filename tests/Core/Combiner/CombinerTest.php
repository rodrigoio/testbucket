<?php

namespace App\Test\Core\Common;

use App\Core\Combiner\AggregatorList;
use PHPUnit\Framework\TestCase;
use App\Core\Combiner\Combiner;
use App\Core\Combiner\Aggregator;
use App\Core\Combiner\Tuple;

/**
 * @group combiner
 */
class CombinerTest extends TestCase
{
    public function testCombine()
    {
        $combiner = new Combiner();

        // Samples
        $tpName = new Tuple('name', 'John');

        $tpAge01 = new Tuple('age', 15);
        $tpAge02 = new Tuple('age', 60);

        $tpStatus01 = new Tuple('status', 1);
        $tpStatus02 = new Tuple('status', 0);


        $possibleNames = new AggregatorList();
        $possibleNames->add(
            Aggregator::createFromTuple($tpName)
        );

        $possibleAges = Aggregator::createFromArray([
            $tpAge01,
            $tpAge02
        ]);

        $firstCombination = $combiner->distribute($possibleNames, $possibleAges);
        $combinedData = json_decode(json_encode($firstCombination), true);

        // aggregator 1
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[0]);
        $this->assertArrayHasKey($tpAge01->getUniqueKey(), $combinedData[0]);

        // aggregator 2
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[1]);
        $this->assertArrayHasKey($tpAge02->getUniqueKey(), $combinedData[1]);
        //
        $this->assertCount(2, $combinedData);

        
        // Test increment aggregates
        $possibleStatuses = Aggregator::createFromArray([
            $tpStatus01,
            $tpStatus02
        ]);
        $secondCombination = $combiner->distribute($firstCombination, $possibleStatuses);
        $combinedData = json_decode(json_encode($secondCombination), true);

        // aggregator 1
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[0]);
        $this->assertArrayHasKey($tpAge01->getUniqueKey(), $combinedData[0]);
        $this->assertArrayHasKey($tpStatus01->getUniqueKey(), $combinedData[0]);

        // aggregator 2
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[1]);
        $this->assertArrayHasKey($tpAge01->getUniqueKey(), $combinedData[1]);
        $this->assertArrayHasKey($tpStatus02->getUniqueKey(), $combinedData[1]);

        // aggregator 3
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[2]);
        $this->assertArrayHasKey($tpAge02->getUniqueKey(), $combinedData[2]);
        $this->assertArrayHasKey($tpStatus01->getUniqueKey(), $combinedData[2]);

        // aggregator 4
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[3]);
        $this->assertArrayHasKey($tpAge02->getUniqueKey(), $combinedData[3]);
        $this->assertArrayHasKey($tpStatus02->getUniqueKey(), $combinedData[3]);
        //
        $this->assertCount(4, $combinedData);
    }
}