<?php

namespace TestBucket\Entity;

class TestCase
{
    private $id;

    /**
     * @var TestGroup
     */
    private $testGroup;

    /**
     * @var TestProperty
     */
    private $testProperty;

    /**
     * @var TestPropertyValue
     */
    private $testPropertyValue;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return TestGroup
     */
    public function getTestGroup(): TestGroup
    {
        return $this->testGroup;
    }

    /**
     * @param TestGroup $testGroup
     */
    public function setTestGroup(TestGroup $testGroup): void
    {
        $this->testGroup = $testGroup;
    }

    /**
     * @return TestProperty
     */
    public function getTestProperty(): TestProperty
    {
        return $this->testProperty;
    }

    /**
     * @param TestProperty $testProperty
     */
    public function setTestProperty(TestProperty $testProperty): void
    {
        $this->testProperty = $testProperty;
    }

    /**
     * @return TestPropertyValue
     */
    public function getTestPropertyValue(): TestPropertyValue
    {
        return $this->testPropertyValue;
    }

    /**
     * @param TestPropertyValue $testPropertyValue
     */
    public function setTestPropertyValue(TestPropertyValue $testPropertyValue): void
    {
        $this->testPropertyValue = $testPropertyValue;
    }
}