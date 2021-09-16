<?php

namespace TestBucket\Core\Controller;

use TestBucket\Core\Combiner\AggregatorList;
use TestBucket\Core\Combiner\Factory as CombinerFactory;
use TestBucket\Core\Combiner\Builder;
use TestBucket\Core\Combiner\Value;
use TestBucket\Core\Specification\Contracts\Group;
use TestBucket\Core\Specification\Contracts\TestCase;
use TestBucket\Core\Specification\Domain\Factory as SpecificationFactory;

class CombinationService
{
    /**
     * @var CombinerFactory
     */
    private $factory;
    /**
     * @var SpecificationFactory
     */
    private $specificationFactory;

    public function __construct(CombinerFactory $factory, SpecificationFactory $specificationFactory)
    {
        $this->factory = $factory;
        $this->specificationFactory = $specificationFactory;
    }

    public function buildTestCasesFromGroup(Group $group)
    {
        if ($this->shouldCombineValues($group)) {
            return $this->convertGroupValuesToTestCases($group);
        }

        $builder = $this->factory->createSpecificationBuilder($group->getName());
        $this->applyPropertiesOfGroup($group, $builder);
        $combinationResult = $builder->getResult();

        return $this->convertToTestCases($combinationResult);
    }

    private function shouldCombineValues(Group $group): bool
    {
        return count($group->getProperties()) == 1;
    }

    private function convertGroupValuesToTestCases(Group $group): array
    {
        $property = null;
        foreach ($group->getProperties() as $oneProperty) {
            $property = $oneProperty;
        }

        $testCases = [];
        foreach ($property->getValues() as $propertyValue) {
            $testCase = $this->specificationFactory->createNewTestCase($propertyValue->isValid());
            $testCase->setGroupName($group->getName());
            $testCase->setProperty($property->getName(), $propertyValue->getValue());
            $testCases[] = $testCase;
        }

        return $testCases;
    }

    private function applyPropertiesOfGroup(Group $group, Builder $builder): void
    {
        foreach ($group->getProperties() as $property) {
            $builder->combinePropertyValues($property->getName(), $this->getArrayOfValues($property));
        }
    }

    private function getArrayOfValues($property): array
    {
        $collectedValues = [];
        foreach ($property->getValues() as $propertyValue){
            $collectedValues[] = new Value($propertyValue->getValue(), $propertyValue->isValid());
        }
        return $collectedValues;
    }

    private function convertToTestCases(AggregatorList $combinationResult): array
    {
        $testCases = [];
        $iterator = $combinationResult->getIterator();

        while ($iterator->valid()) {
            $aggregator = $iterator->current();
            $testCases[] = $this->createTestCaseFromTuples($aggregator->toArray());
            $iterator->next();
        }

        return $testCases;
    }

    private function createTestCaseFromTuples(array $tuples)
    {
        [$groupMap, $isValid] = $this->extractTestCaseData($tuples);

        return $this->createTestCase($isValid, $groupMap);
    }

    private function extractTestCaseData(array $tuples): array
    {
        $groupMap = [];
        $isValid = true;
        foreach ($tuples as $tuple) {
            if (!$tuple->isValid()) {
                $isValid = false;
            }
            $groupMap[$tuple->getGroup()][$tuple->getProperty()] = $tuple->getValue();
        }
        return [$groupMap, $isValid];
    }

    private function createTestCase($isValid, $groupMap): TestCase
    {
        $testCase = $this->specificationFactory->createNewTestCase($isValid);
        foreach ($groupMap as $groupName => $properties) {
            $testCase->setGroupName($groupName);
            foreach ($properties as $propertyName => $propertyValue) {
                $testCase->setProperty($propertyName, $propertyValue);
            }
        }
        return $testCase;
    }
}
