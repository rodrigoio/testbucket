<?php

namespace TestBucket\Test\Core\Combiner;

use TestBucket\Core\Combiner\Value;
use TestBucket\Tests\UnitTests\BaseUnitTestCase;

/**
 * @group combiner_value
 * @group combiner
 */
class ValueTest extends BaseUnitTestCase
{
    /**
     * @var string
     */
    private $mixedValue;

    public function setUp()
    {
        parent::setUp();
        $this->mixedValue = "some value";
    }

    public function testImplicitValidValue()
    {
        $value = new Value($this->mixedValue);
        $this->assertValue($this->mixedValue, $value, true);
    }

    public function testExplicitValidValue()
    {
        $value = new Value($this->mixedValue, true);
        $this->assertValue($this->mixedValue, $value, true);
    }

    public function testExplicitInvalidValue()
    {
        $value = new Value($this->mixedValue, false);
        $this->assertValue($this->mixedValue, $value, false);
    }

    private function assertValue(string $mixedValue, Value $validValue1, bool $isValid): void
    {
        $this->assertEquals($mixedValue, $validValue1->getValue());
        $this->assertSame($isValid, $validValue1->isValid());
    }
}
