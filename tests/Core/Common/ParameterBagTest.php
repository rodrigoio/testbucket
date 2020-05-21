<?php
namespace App\Test\Core\Common;

use PHPUnit\Framework\TestCase;
use App\Core\Common\ParameterBag;

/**
 * @group spec
 */
class ParameterBagTest extends TestCase
{
    public function testSetAndGetParameters()
    {
        $parameter = new ParameterBag();
        $parameter->put('spring', 99);
        $parameter->put('winter', 'abc');

        $this->assertEquals(99, $parameter->get('spring'));
        $this->assertEquals('abc', $parameter->get('winter'));
        $this->assertEquals(2, $parameter->count());
    }
}
