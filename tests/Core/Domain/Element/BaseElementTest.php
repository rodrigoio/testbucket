<?php
namespace App\Test\Core\Domain\Element;

use App\Core\Domain\Element\BaseElement;
use PHPUnit\Framework\TestCase;

/**
 * @group Element
 */
class BaseElementTest extends TestCase
{
    public function testIfCanCreateNewAbstractElement()
    {
        $element = new BaseElement('key1', 'value1');
        $this->assertEquals('key1', $element->getKey());
        $this->assertEquals('value1', $element->getValue());
    }

    public function testIfCanCompareTwoElements()
    {
        $element1 = new BaseElement('key1', 'value1');
        $element2 = new BaseElement('key1', 'value1');
        $this->assertTrue($element1->equals($element2));

        $element3 = new BaseElement('key1', 'value3');
        $this->assertFalse($element1->equals($element3));

        $element4 = new BaseElement('key4', 'value1');
        $this->assertFalse($element1->equals($element4));
    }
}
