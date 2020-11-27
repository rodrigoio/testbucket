<?php
namespace TestBucket\Test\Core\Specification;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Common\ParameterBag;
use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Specification\Field;
use TestBucket\Core\Specification\FieldList;

/**
 * @group spec
 */
class FieldIteratorTest extends TestCase
{
    public function testCreateFieldIterator()
    {
        $list = new FieldList();
        $list->add( $this->createNewField('first_name') );
        $list->add( $this->createNewField('last_name') );

        $fields = [
            0 => 'first_name',
            1 => 'last_name',
        ];

        $iterator = $list->getIterator();
        foreach ($iterator as $key=>$field) {
            $this->assertEquals($fields[$key], $field->getName());
        }

        $iterator = $list->getIterator();
        while ($iterator->valid()) {
            $field = $iterator->current();
            $this->assertEquals($fields[$iterator->key()], $field->getName());
            $iterator->next();
        }
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
