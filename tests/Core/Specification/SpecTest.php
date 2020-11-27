<?php
namespace TestBucket\Test\Core\Specification;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Common\ParameterBag;
use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Specification\Field;
use TestBucket\Core\Specification\FieldList;
use TestBucket\Core\Specification\Spec;

/**
 * @group spec
 */
class SpecTest extends TestCase
{
    public function testCreateSpec()
    {
        $list = $this->createNewList();
        $spec = new Spec('1.0', 'user_form', $list);

        $this->assertEquals('1.0', $spec->getVersion());
        $this->assertEquals('user_form', $spec->getName());
        $this->assertInstanceOf(FieldList::class, $spec->getFields());
    }

    public function testInvalidSpecVersion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No version defined');

        $list = $this->createNewList();
        $spec = new Spec('', 'user_form', $list);
    }

    public function testInvalidSpecName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No name defined');

        $list = $this->createNewList();
        $spec = new Spec('1.0', '', $list);
    }

    public function testInvalidSpecFields()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No fields defined');

        $spec = new Spec('1.0', 'user_form', new FieldList());
    }

    private function createNewList() : FieldList
    {
        $list = new FieldList();
        $list->add( $this->createNewField('first_name') );
        $list->add( $this->createNewField('last_name') );
        return $list;
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
