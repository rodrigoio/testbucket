<?php
namespace App\Test\Core\DataStructures;

use App\Core\DataStructures\AbstractCollection;
use App\Core\Domain\Element\BaseElement;
use PHPUnit\Framework\TestCase;

/**
 * @group Collection
 */
class AbstractCollectionTest extends TestCase
{
    public function testIfCanCreateNewAbstractCollection()
    {
        $collection = new AbstractCollection();
        $this->assertTrue($collection->isEmpty());

        $collection->add(new BaseElement('key', 'value'));
        $this->assertFalse($collection->isEmpty());
        $this->assertTrue($collection->getIterator()->count() == 1);

        $collection->add(new BaseElement('key', 'value'));
        $collection->add(new BaseElement('key', 'value'));
        $this->assertTrue($collection->getIterator()->count() == 3);
    }
}
