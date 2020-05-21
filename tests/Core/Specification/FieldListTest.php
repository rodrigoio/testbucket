<?php
namespace App\Test\Core\Specification;

use PHPUnit\Framework\TestCase;
use App\Core\Common\ParameterBag;
use App\Core\Specification\Domain;
use App\Core\Specification\Field;
use App\Core\Specification\FieldList;

/**
 * @group spec
 */
class FieldListTest extends TestCase
{
    public function testCreateFieldList()
    {
        $list = new FieldList();
        // add
        $list->add( $this->createNewField('first_name') );
        $list->add( $this->createNewField('last_name') );

        // count
        $this->assertEquals(2, $list->count());

        // get
        $this->assertInstanceOf(Field::class, $list->get(0));
        $this->assertInstanceOf(Field::class, $list->get(1));
        $this->assertEquals(null, $list->get(99));

        // set
        $this->assertEquals('last_name', $list->get(1)->getName());
        $list->set( $this->createNewField('bio'), 1);
        $this->assertEquals('bio', $list->get(1)->getName());

        // getIterator
        $this->assertInstanceOf(\Iterator::class, $list->getIterator());
    }

    private function createNewField($name) : Field
    {
        $parameter = new ParameterBag();
        $parameter->put('max', 255);
        $parameter->put('min', 10);

        $domain = new Domain('Alpha', $parameter);
        return new Field($name, $domain);
    }
}
