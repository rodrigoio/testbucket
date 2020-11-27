<?php
namespace TestBucket\Test\Core\Specification;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Common\ParameterBag;
use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Specification\Field;

/**
 * @group spec
 */
class FieldTest extends TestCase
{
    public function testCreateField()
    {
        $parameter = new ParameterBag();
        $parameter->put('max', 10);
        $parameter->put('min', 2);
        $domain = new Domain('Alpha', $parameter);

        $field = new Field('first_name', $domain);

        $this->assertEquals('first_name', $field->getName());
        $this->assertEquals('Alpha', $field->getDomain()->getType());
        $this->assertEquals(10, $domain->getParameters()->get('max'));
        $this->assertEquals(2, $domain->getParameters()->get('min'));
    }

    public function testInvalidFieldName()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid field name');

        $domain = new Domain('Alpha', new ParameterBag());
        $field = new Field('', $domain);
    }
}