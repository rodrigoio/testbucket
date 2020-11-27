<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Core\Combiner\Aggregator;
use TestBucket\Core\Combiner\Tuple;
use PHPUnit\Framework\TestCase;

/**
 * @group combiner_aggregator
 * @group combiner
 */
class AggregatorTest extends TestCase
{
    public function testCreate()
    {
        $aggregator = new Aggregator();
        $this->assertEquals([], $aggregator->toArray());

        $tuple01 = new Tuple('group1', 'age', 10);
        $tuple02 = new Tuple('group1', 'status', 1);

        $aggregator = Aggregator::createFromTuple($tuple01);
        $this->assertEquals(['group1:age:(MTA=)' => $tuple01], $aggregator->toArray());

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);
        $this->assertEquals(
            [
                'group1:age:(MTA=)' => $tuple01,
                'group1:status:(MQ==)' => $tuple02
            ],
            $aggregator->toArray()
        );

        $aggregator = Aggregator::createFromArray([]);
        $this->assertEquals([], $aggregator->toArray());
    }

    public function testClone()
    {
        $tuple01 = new Tuple('group1', 'age', 10);

        $aggregatorA = Aggregator::createFromTuple($tuple01);
        $aggregatorB = $aggregatorA->makeClone();
        $this->assertEquals($aggregatorB->toArray(), $aggregatorA->toArray());
    }

    public function testJsonSerialize()
    {
        $tuple01 = new Tuple('group1', 'age', 10);
        $tuple02 = new Tuple('group1', 'status', 1);

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);

        $data = json_encode($aggregator);

        $this->assertEquals(
            [
                'group1:age:(MTA=)' => [
                    'key' => 'age',
                    'value' => 10,
                ],
                'group1:status:(MQ==)' => [
                    'key' => 'status',
                    'value' => 1,
                ]
            ],
            json_decode($data, true)
        );
    }

    public function testSplitAggregator()
    {
        $aggregator = new Aggregator();
        $this->assertEquals([], $aggregator->toArray());

        $tuple01 = new Tuple('group1', 'age', 10);
        $tuple02 = new Tuple('group1', 'age', 8);

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);
        $this->assertEquals(
            [
                'group1:age:(MTA=)' => $tuple01,
                'group1:age:(OA==)' => $tuple02
            ],
            $aggregator->toArray()
        );

        $aggregatorList = $aggregator->split();
        $data = json_decode(json_encode($aggregatorList), true);

        $this->assertEquals(
            [
                ['group1:age:(MTA=)' => ['key' => 'age', 'value' => 10]],
                ['group1:age:(OA==)' => ['key' => 'age', 'value' => 8]]
            ],
            $data
        );
    }
}
