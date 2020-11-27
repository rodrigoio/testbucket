<?php
namespace TestBucket\Test\Core\DataSource;

use TestBucket\Core\DataSource\ConcreteDataSource;
use PHPUnit\Framework\TestCase;

/**
 * @group DataSource
 */
class ConcreteDataSourceTest extends TestCase
{
    public function testNewConcreteDomain()
    {
        $concrete = new ConcreteDataSource([]);

        $collection = $concrete->getAll();
        $this->assertInstanceOf(\TestBucket\Core\DataStructures\Collection::class, $collection);

        $this->assertTrue($collection->isEmpty());
    }

    public function testConcreteDataSourceWithFilledArray()
    {
        $concrete = new ConcreteDataSource(['bazz', 'wk', 'mgm', 'bob']);

        $collection = $concrete->getAll();

        $this->assertEquals(4, $collection->getIterator()->count());

        foreach (['bazz', 'wk', 'mgm', 'bob'] as $key=>$value) {

            $collectionValue = $collection->getIterator()->offsetGet($key);
            $this->assertEquals($value, $collectionValue);
        }

        $this->assertFalse($collection->isEmpty());
    }
}