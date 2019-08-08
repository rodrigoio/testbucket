<?php
namespace App\Test\Core\Domain\Concrete;

use App\Core\Domain\Concrete\ConcreteDomain;
use App\Core\DataSource\ConcreteDataSource;
use PHPUnit\Framework\TestCase;

/**
 * @group Concrete
 */
class ConcreteDomainTest extends TestCase
{
    public function testNewConcreteDomain()
    {
        $concrete = new ConcreteDomain(new ConcreteDataSource(['test']));

        $this->assertFalse($concrete->isEmpty());
    }
}
