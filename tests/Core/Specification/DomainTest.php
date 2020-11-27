<?php
namespace TestBucket\Test\Core\Specification;

use PHPUnit\Framework\TestCase;
use TestBucket\Core\Specification\Domain;
use TestBucket\Core\Common\ParameterBag;

/**
 * @group spec
 */
class DomainTest extends TestCase
{
    public function testCreateDomain()
    {
        $parameter = new ParameterBag();
        $parameter->put('name', 'abc');

        $domain = new Domain('DomainType', $parameter);

        $this->assertEquals('DomainType', $domain->getType());
        $this->assertEquals('abc', $domain->getParameters()->get('name'));
    }

    public function testInvalidDomainType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid type');

        $domain = new Domain('', new ParameterBag());
    }
}
