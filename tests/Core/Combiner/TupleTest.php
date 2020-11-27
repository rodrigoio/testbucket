<?php

namespace TestBucket\Test\Core\Common;

use TestBucket\Core\Combiner\Tuple;
use PHPUnit\Framework\TestCase;

/**
 * @group combiner_tuple
 * @group combiner
 */
class TupleTest extends TestCase
{
    public function testTuple()
    {
        $tuple = new Tuple('group01', 'key01', 'value99');

        $this->assertEquals('group01', $tuple->getGroup());
        $this->assertEquals('key01', $tuple->getKey());
        $this->assertEquals('value99', $tuple->getValue());
        $this->assertEquals('group01:key01:(dmFsdWU5OQ==)', $tuple->getUniqueKey());

        $jsonTuple = json_encode($tuple);

        $arrayTupple = [
            'key' => 'key01',
            'value' => 'value99',
        ];

        $this->assertEquals($arrayTupple, json_decode($jsonTuple, true));
    }
}