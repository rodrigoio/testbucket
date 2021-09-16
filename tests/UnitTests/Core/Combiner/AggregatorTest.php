<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\Aggregator;
use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group combiner_aggregator
 * @group combiner
 */
class AggregatorTest extends BaseUnitTestCase
{
    /** @var Aggregator */
    private $aggregator;
    /**
     * @var Tuple
     */
    private $tupleAge, $tupleStatus;

    public function setUp()
    {
        parent::setUp();
        $this->aggregator = new Aggregator();
        $this->tupleAge = new Tuple('group1', 'age', new Value(10));
        $this->tupleStatus = new Tuple('group1', 'status', new Value(1));
    }

    private function setUpWithTuple(Tuple $tuple): void
    {
        $this->aggregator = Aggregator::createFromTuple($tuple);
    }

    private function setUpWithTuples(array $tuples): void
    {
        $this->aggregator = Aggregator::createFromArray($tuples);
    }

    private function assertResult($expected)
    {
        $this->assertEquals($expected, $this->aggregator->toArray());
    }

    public function testEmptyAggregator()
    {
        $this->assertResult([]);
    }

    public function testCreateWithOneTuple()
    {
        $this->setUpWithTuple($this->tupleAge);

        $this->assertResult(['group1:age:d3d9446802a44259755d38e6d163e820:1' => $this->tupleAge]);
    }

    public function testCreateWithTwoTuples()
    {
        $this->setUpWithTuples([
            $this->tupleAge,
            $this->tupleStatus
        ]);

        $this->assertResult([
            'group1:age:d3d9446802a44259755d38e6d163e820:1' => $this->tupleAge,
            'group1:status:c4ca4238a0b923820dcc509a6f75849b:1' => $this->tupleStatus
        ]);
    }

    public function testClone()
    {
        $this->setUpWithTuple($this->tupleAge);

        $aggregatorClone = $this->aggregator->makeClone();

        $this->assertResult($aggregatorClone->toArray());
    }

    public function testSplitAggregator()
    {
        $this->setUpWithTuples([
            $this->tupleAge,
            $this->tupleStatus
        ]);

        $aggregatorList = $this->aggregator->split();
        $this->assertEquals(2, $aggregatorList->count());

        $this->aggregator = $aggregatorList->get(0);
        $this->assertResult([
            'group1:age:d3d9446802a44259755d38e6d163e820:1' => $this->tupleAge
        ]);

        $this->aggregator = $aggregatorList->get(1);
        $this->assertResult([
            'group1:status:c4ca4238a0b923820dcc509a6f75849b:1' => $this->tupleStatus
        ]);
    }
}
