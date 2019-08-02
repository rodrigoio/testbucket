<?php
namespace App\Test\Domain;

use App\Domain\StaticValueDomain;
use PHPUnit\Framework\TestCase;

/**
 * @group Core
 */
class StaticValueDomainTest extends TestCase
{
    public function testIfHasItems()
    {
        $domain = new StaticValueDomain();
    }
}