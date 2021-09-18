<?php

namespace TestBucket\Test\Core\Combiner;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Combiner\Aggregator;
use TestBucket\Core\Combiner\AggregatorList;
use TestBucket\Core\Combiner\Combiner;
use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;

/**
 * @group combiner_combiner
 */
class CombinerTest extends TestCase
{
    /**
     * @var Combiner
     */
    private $combiner;
    /**
     * @var Tuple
     */
    private $tupleAge15, $tupleAge50, $tupleAge60, $tupleName, $tupleStatus01, $tupleStatus02;
    /**
     * @var AggregatorList
     */
    private $leftAggregatorList;
    /**
     * @var Aggregator
     */
    private $rightAggregator;
    /**
     * @var AggregatorList
     */
    private $combinationResult;

    public function setUp()
    {
        parent::setUp();
        $this->combiner = new Combiner();
        $this->tupleAge15 = new Tuple('user','age', new Value(15));
        $this->tupleAge50 = new Tuple('user','age', new Value(50));
        $this->tupleAge60 = new Tuple('user','age', new Value(60));
        $this->tupleName = new Tuple('user','name', new Value('John'));
        $this->tupleStatus01 = new Tuple('user','status', new Value(1));
        $this->tupleStatus02 = new Tuple('user','status', new Value(0));
        $this->leftAggregatorList = null;
        $this->rightAggregator = null;
    }

    private function setUpParameters($tuplesLeft, array $tuplesRight): void
    {
        if (is_array($tuplesLeft)) {
            $this->leftAggregatorList = AggregatorList::createFromArray([
                Aggregator::createFromArray($tuplesLeft)
            ]);
        } else {
            $this->leftAggregatorList = $tuplesLeft;
        }

        $this->rightAggregator = Aggregator::createFromArray($tuplesRight);
    }

    private function assertCombination($expected): void
    {
        foreach ($expected as $index=>$expectedAggregator) {
            $resultData = $this->combinationResult->get($index)->toArray();
            foreach ($expectedAggregator as $tupleKey)
                $this->assertArrayHasKey($tupleKey, $resultData);
        }
        $this->assertEquals(count($expected), $this->combinationResult->count());
    }

    private function runUnitaryDistribution(): void
    {
        $this->combinationResult = $this->combiner->unitaryDistribution(
            $this->leftAggregatorList,
            $this->rightAggregator
        );
    }

    private function runDistribution(): void
    {
        $this->combinationResult = $this->combiner->distribution(
            $this->leftAggregatorList,
            $this->rightAggregator
        );
    }


    public function testDistributionWithSamePropertyAndUnitaryRoot()
    {
        $this->setUpParameters(
            [
                $this->tupleAge15 // one root
            ],
            [
                $this->tupleAge50,
                $this->tupleAge60
            ]
        );

        $this->runUnitaryDistribution();

        $this->assertCombination([
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge50->getUniqueKey()
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge60->getUniqueKey()
            ]
        ]);
    }

    public function testDistributionWithUnitaryRootUsingTwoSteps()
    {
        $this->setUpParameters(
            [
                $this->tupleAge15 // one root
            ],
            [
                $this->tupleAge50,
                $this->tupleAge60
            ]
        );

        $this->runUnitaryDistribution();

        $this->assertCombination([
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge50->getUniqueKey()
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge60->getUniqueKey()
            ]
        ]);

        $this->setUpParameters(
            $this->combinationResult,
            [
                $this->tupleStatus01,
                $this->tupleStatus02,
            ]
        );

        $this->runUnitaryDistribution();

        $this->assertCombination([
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge50->getUniqueKey(),
                $this->tupleStatus01->getUniqueKey(),
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge50->getUniqueKey(),
                $this->tupleStatus02->getUniqueKey(),
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge60->getUniqueKey(),
                $this->tupleStatus01->getUniqueKey(),
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleAge60->getUniqueKey(),
                $this->tupleStatus02->getUniqueKey(),
            ]
        ]);
    }

    public function testDistributionWithMultipleRootNode()
    {
        $this->setUpParameters(
            [
                $this->tupleAge15,
                $this->tupleAge50,
                $this->tupleAge60,
            ],
            [
                $this->tupleName,
                $this->tupleStatus01,
                $this->tupleStatus02,
            ]
        );

        $this->runDistribution();

        $this->assertCombination([
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleName->getUniqueKey(),
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleStatus01->getUniqueKey(),
            ],
            [
                $this->tupleAge15->getUniqueKey(),
                $this->tupleStatus02->getUniqueKey(),
            ],
            [
                $this->tupleAge50->getUniqueKey(),
                $this->tupleName->getUniqueKey(),
            ],
            [
                $this->tupleAge50->getUniqueKey(),
                $this->tupleStatus01->getUniqueKey(),
            ],
            [
                $this->tupleAge50->getUniqueKey(),
                $this->tupleStatus02->getUniqueKey(),
            ],
            [
                $this->tupleAge60->getUniqueKey(),
                $this->tupleName->getUniqueKey(),
            ],
            [
                $this->tupleAge60->getUniqueKey(),
                $this->tupleStatus01->getUniqueKey(),
            ],
            [
                $this->tupleAge60->getUniqueKey(),
                $this->tupleStatus02->getUniqueKey(),
            ]
        ]);
    }
}
