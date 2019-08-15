<?php
namespace App\Test\Core\Domain\Element;

use App\Core\Domain\Element\Element;
use PHPUnit\Framework\TestCase;

/**
 * @group ElementInterface
 */
class BaseElementTest extends TestCase
{
    public function testIfCanCreateNewAbstractElement()
    {
        $element = new Element('value1');
        $this->assertEquals('value1', $element->getValue());
    }

    public function testIfCanCompareTwoElements()
    {
        $element1 = new Element('value1');
        $element2 = new Element('value1');
        $this->assertTrue($element1->equals($element2));


        $element3 = new Element('value3');
        $this->assertFalse($element1->equals($element3));
    }
}
