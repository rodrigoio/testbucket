<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\Tuple;
use TestBucket\Core\Combiner\Value;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group combiner_tuple
 * @group combiner
 */
class TupleTest extends BaseUnitTestCase
{
    public function testTuple()
    {
        $tuple = new Tuple('group01', 'key01', new Value('value99', true));

        $this->assertEquals('group01', $tuple->getGroup());
        $this->assertEquals('key01', $tuple->getProperty());
        $this->assertEquals('value99', $tuple->getValue());
        $this->assertEquals(true, $tuple->isValid());
        $this->assertEquals('group01:key01:c7e1f73aaf2820fce23887b6cf397164:1', $tuple->getUniqueKey());
    }
}
