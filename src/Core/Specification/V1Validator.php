<?php

namespace TestBucket\Core\Specification;

use TestBucket\Core\Specification\Contracts\Validator;

class V1Validator implements Validator
{
//    public function validate($structure): void
//    {
//        $this->mustHaveKey('version', $structure);
//        $this->mustHaveValue('version', $structure, 1);
//
//        $this->mustHaveKey('group', $structure);
//        $this->mustNotBeNull('group', $structure);
//
//        $this->mustHaveKey('properties', $structure);
//        $this->mustBeArray('properties', $structure);
//
//        $this->validateProperties($structure['properties']);
//    }
//
//    private function validateProperties($properties)
//    {
//        foreach ($properties as $property) {
//            $this->mustHaveKey('name', $property);
//            $this->mustNotBeNull('name', $property);
//
//            $this->mustHaveKey('type', $property);
//            $this->mustNotBeNull('type', $property);
//
//            $this->mustHaveKey('value', $property);
//            $this->mustNotBeNull('value', $property);
//        }
//    }
//
//    private function mustHaveKey(string $property, array $array)
//    {
//        if (!array_key_exists($property, $array)) {
//            throw new InvalidArgumentException("Must have the property: $property");
//        }
//    }
//
//    private function mustHaveValue(string $property, array $array, $expectedValue)
//    {
//        if ($array[$property] != $expectedValue) {
//            throw new InvalidArgumentException("Value of property: $property, must be $expectedValue");
//        }
//    }
//
//    private function mustNotBeNull(string $property, array $array)
//    {
//        if (is_null($array[$property])) {
//            throw new InvalidArgumentException("Value of property: $property, must not be null");
//        }
//    }
//
//    private function mustBeArray(string $property, array $array)
//    {
//        if (!is_array($array[$property])) {
//            throw new InvalidArgumentException("Value of property: $property, must be array");
//        }
//    }
    public function validate($structure): void
    {
        // TODO: Implement validate() method.
    }
}
