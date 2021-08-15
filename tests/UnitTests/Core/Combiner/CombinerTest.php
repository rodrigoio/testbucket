<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\Aggregator;
use TestBucket\Core\Combiner\AggregatorList;
use TestBucket\Core\Combiner\Combiner;
use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group combiner
 */
class CombinerTest extends BaseUnitTestCase
{
    /**
     * @group combine_with_unitary_root
     */
    public function testDistributionWithUnitaryRootNode()
    {
        $combiner = new Combiner();

        // Samples
        $tpName = new Tuple('user','name', new Value('John'));
        $tpAge01 = new Tuple('user','age', new Value(15));
        $tpAge02 = new Tuple('user','age', new Value(60));

        $possibleNames = AggregatorList::createFromArray([
            Aggregator::createFromTuple($tpName)
        ]);
        $possibleAges = Aggregator::createFromArray([
            $tpAge01,
            $tpAge02
        ]);

        $firstCombination = $combiner->unitaryDistribution($possibleNames, $possibleAges);
        $combinedData = json_decode(json_encode($firstCombination), true);

        // aggregator 1
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[0]);
        $this->assertArrayHasKey($tpAge01->getUniqueKey(), $combinedData[0]);

        // aggregator 2
        $this->assertArrayHasKey($tpName->getUniqueKey(), $combinedData[1]);
        $this->assertArrayHasKey($tpAge02->getUniqueKey(), $combinedData[1]);
        //
        $this->assertCount(2, $combinedData);

        // ----------------------------------------------------------------------

        // Samples
        $tpStatus01 = new Tuple('user','status', new Value(1));
        $tpStatus02 = new Tuple('user','status', new Value(0));

        // Test increment aggregates
        $possibleStatuses = Aggregator::createFromArray([
            $tpStatus01,
            $tpStatus02
        ]);
        $secondCombination = $combiner->unitaryDistribution($firstCombination, $possibleStatuses);
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

        // Total combinations
        $this->assertCount(4, $combinedData);
    }

    /**
     * @group combine_with_multiple_root
     */
    public function testDistributionWithMultipleRootNode()
    {
        $combiner = new Combiner();

        $tpStatus01 = new Tuple('user', 'status', new Value('on'));
        $tpStatus02 = new Tuple('user', 'status', new Value('off'));
        $tpStatus03 = new Tuple('user', 'status', new Value('inter'));

        $tpPassword01 = new Tuple('user', 'region', new Value('10'));
        $tpPassword02 = new Tuple('user', 'region', new Value('20'));
        $tpPassword03 = new Tuple('user', 'region', new Value('30'));

        $aggregatorStatus = Aggregator::createFromArray([
            $tpStatus01,
            $tpStatus02,
            $tpStatus03,
        ]);
        $aggregatorList = AggregatorList::createFromArray([
            $aggregatorStatus
        ]);

        $aggregatorPasswordType = Aggregator::createFromArray([
            $tpPassword01,
            $tpPassword02,
            $tpPassword03,
        ]);

        $combined = $combiner->distribution($aggregatorList, $aggregatorPasswordType);
        $combinedData = json_decode(json_encode($combined), true);

        // aggregator 1
        $this->assertArrayHasKey($tpStatus01->getUniqueKey(), $combinedData[0]);
        $this->assertArrayHasKey($tpPassword01->getUniqueKey(), $combinedData[0]);

        // aggregator 2
        $this->assertArrayHasKey($tpStatus01->getUniqueKey(), $combinedData[1]);
        $this->assertArrayHasKey($tpPassword02->getUniqueKey(), $combinedData[1]);

        // aggregator 3
        $this->assertArrayHasKey($tpStatus01->getUniqueKey(), $combinedData[2]);
        $this->assertArrayHasKey($tpPassword03->getUniqueKey(), $combinedData[2]);

        // aggregator 4
        $this->assertArrayHasKey($tpStatus02->getUniqueKey(), $combinedData[3]);
        $this->assertArrayHasKey($tpPassword01->getUniqueKey(), $combinedData[3]);

        // aggregator 5
        $this->assertArrayHasKey($tpStatus02->getUniqueKey(), $combinedData[4]);
        $this->assertArrayHasKey($tpPassword02->getUniqueKey(), $combinedData[4]);

        // aggregator 6
        $this->assertArrayHasKey($tpStatus02->getUniqueKey(), $combinedData[5]);
        $this->assertArrayHasKey($tpPassword03->getUniqueKey(), $combinedData[5]);

        // aggregator 7
        $this->assertArrayHasKey($tpStatus03->getUniqueKey(), $combinedData[6]);
        $this->assertArrayHasKey($tpPassword01->getUniqueKey(), $combinedData[6]);

        // aggregator 8
        $this->assertArrayHasKey($tpStatus03->getUniqueKey(), $combinedData[7]);
        $this->assertArrayHasKey($tpPassword02->getUniqueKey(), $combinedData[7]);

        // aggregator 9
        $this->assertArrayHasKey($tpStatus03->getUniqueKey(), $combinedData[8]);
        $this->assertArrayHasKey($tpPassword03->getUniqueKey(), $combinedData[8]);

        // Total combinations
        $this->assertCount(9, $combinedData);
    }
}
