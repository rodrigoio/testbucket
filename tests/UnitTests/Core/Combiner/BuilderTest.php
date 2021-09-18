<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\AggregatorList;
use TestBucket\Core\Combiner\Builder;
use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;
use PHPUnit\Framework\TestCase;

/**
 * @group combiner_spec_builder
 * @group combiner
 */
class BuilderTest extends TestCase
{
    /**
     * @var AggregatorList
     */
    private $combinationResult;
    /**
     * @var Value
     */
    private $age20, $age45, $age60, $status0, $status1, $status2, $emailOk;
    /**
     * @var Builder
     */
    private $builder;

    public function setUp()
    {
        parent::setUp();

        $this->age20 = new Value(20);
        $this->age45 = new Value(45);
        $this->age60 = new Value(60);
        $this->status0 = new Value(0);
        $this->status1 = new Value(1);
        $this->status2 = new Value(2);
        $this->emailOk = new Value('email@email.com');
        $this->builder = new Builder('group1');
    }

    private function getCombinationResult()
    {
        $this->combinationResult = $this->builder->getResult();
    }

    public function testBuildWithoutProperties()
    {
        $this->expectExceptionMessage("Invalid empty field");

        $this->builder->combinePropertyValues('invalid_empty_field', []);

        $this->getCombinationResult();
    }

    public function testBuildWithOneProperty()
    {

        $this->builder->combinePropertyValues('age', [$this->age20, $this->age45, $this->age60]);

        $this->getCombinationResult();

        $this->assertCombination([
            [
                $this->getUniqueKey('group1', 'age', 20),
                $this->getUniqueKey('group1', 'age', 45),
                $this->getUniqueKey('group1', 'age', 60),
            ]
        ]);
    }

    private function getUniqueKey($group, $property, $value)
    {
        return (new Tuple($group, $property, new Value($value)))->getUniqueKey();
    }

    public function testBuildMultipleProperties()
    {
        $this->builder
            ->combinePropertyValues('age', [$this->age20, $this->age45, $this->age60])
            ->combinePropertyValues('status', [$this->status0, $this->status1, $this->status2])
            ->combinePropertyValues('email', [$this->emailOk]);

        $this->getCombinationResult();

        $this->assertCombination([
            [
                $this->getUniqueKey('group1', 'age', 20),
                $this->getUniqueKey('group1', 'status', 0),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 20),
                $this->getUniqueKey('group1', 'status', 1),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 20),
                $this->getUniqueKey('group1', 'status', 2),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],

            [
                $this->getUniqueKey('group1', 'age', 45),
                $this->getUniqueKey('group1', 'status', 0),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 45),
                $this->getUniqueKey('group1', 'status', 1),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 45),
                $this->getUniqueKey('group1', 'status', 2),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],

            [
                $this->getUniqueKey('group1', 'age', 60),
                $this->getUniqueKey('group1', 'status', 0),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 60),
                $this->getUniqueKey('group1', 'status', 1),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
            [
                $this->getUniqueKey('group1', 'age', 60),
                $this->getUniqueKey('group1', 'status', 2),
                $this->getUniqueKey('group1', 'email', 'email@email.com'),
            ],
        ]);
    }

    private function assertCombination(array $expected=null): void
    {
        if (!empty($expected))
        foreach ($expected as $index=>$expectedAggregator) {
            $resultData = $this->combinationResult->get($index)->toArray();
            foreach ($expectedAggregator as $tupleKey)
                $this->assertArrayHasKey($tupleKey, $resultData);
        }

        $this->assertEquals(count($expected), $this->combinationResult->count());
    }
}
