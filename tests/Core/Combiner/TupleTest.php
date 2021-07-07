<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;
use PHPUnit\Framework\TestCase;

/**
 * @group combiner_tuple
 * @group combiner
 */
class TupleTest extends TestCase
{
    public function testTuple()
    {
        $tuple = new Tuple('group01', 'key01', new Value('value99', true));

        $this->assertEquals('group01', $tuple->getGroup());
        $this->assertEquals('key01', $tuple->getProperty());
        $this->assertEquals('value99', $tuple->getValue());
        $this->assertEquals('group01:key01:(dmFsdWU5OQ==):1', $tuple->getUniqueKey());

        $jsonTuple = json_encode($tuple);

        $arrayTupple = [
            'group' => 'group01',
            'property' => 'key01',
            'value' => 'value99',
            'is_valid' => true,
        ];

        $this->assertEquals($arrayTupple, json_decode($jsonTuple, true));
    }
}
