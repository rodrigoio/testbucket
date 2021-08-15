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
    public function testCreate()
    {
        $aggregator = new Aggregator();
        $this->assertEquals([], $aggregator->toArray());

        $tuple01 = new Tuple('group1', 'age', new Value(10));
        $tuple02 = new Tuple('group1', 'status', new Value(1));

        $aggregator = Aggregator::createFromTuple($tuple01);
        $this->assertEquals(['group1:age:(MTA=):1' => $tuple01], $aggregator->toArray());

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);
        $this->assertEquals(
            [
                'group1:age:(MTA=):1' => $tuple01,
                'group1:status:(MQ==):1' => $tuple02
            ],
            $aggregator->toArray()
        );

        $aggregator = Aggregator::createFromArray([]);
        $this->assertEquals([], $aggregator->toArray());
    }

    public function testClone()
    {
        $tuple01 = new Tuple('group1', 'age', new Value(10));

        $aggregatorA = Aggregator::createFromTuple($tuple01);
        $aggregatorB = $aggregatorA->makeClone();
        $this->assertEquals($aggregatorB->toArray(), $aggregatorA->toArray());
    }

    public function testJsonSerialize()
    {
        $tuple01 = new Tuple('group1', 'age', new Value(10));
        $tuple02 = new Tuple('group1', 'status', new Value(1));

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);

        $data = json_encode($aggregator);
        $this->assertEquals(
            [
                'group1:age:(MTA=):1' => [
                    'group' => 'group1',
                    'property' => 'age',
                    'value' => '10',
                    'is_valid' => true
                ],
                'group1:status:(MQ==):1' => [
                    'group' => 'group1',
                    'property' => 'status',
                    'value' => '1',
                    'is_valid' => true
                ]
            ],
            json_decode($data, true)
        );
    }

    public function testSplitAggregator()
    {
        $aggregator = new Aggregator();
        $this->assertEquals([], $aggregator->toArray());

        $tuple01 = new Tuple('group1', 'age', new Value(10));
        $tuple02 = new Tuple('group1', 'age', new Value(8));

        $aggregator = Aggregator::createFromArray([
            $tuple01,
            $tuple02
        ]);
        $this->assertEquals(
            [
                'group1:age:(MTA=):1' => $tuple01,
                'group1:age:(OA==):1' => $tuple02
            ],
            $aggregator->toArray()
        );

        $aggregatorList = $aggregator->split();
        $data = json_decode(json_encode($aggregatorList), true);

        $this->assertEquals([
            "group1:age:(MTA=):1" => [
                "group" => "group1",
                "property" => "age",
                "value" => "10",
                "is_valid" => "1"
            ]
        ], $data[0]);

        $this->assertEquals([
            "group1:age:(OA==):1" => [
                "group" => "group1",
                "property" => "age",
                "value" => "8",
                "is_valid" => "1"
            ]
        ], $data[1]);
    }
}
