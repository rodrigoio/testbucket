<?php
namespace App\Test\Repository\Domains\Numbers;

use PHPUnit\Framework\TestCase;
use App\Repository\Domains\Numbers\Integer;

class IntegerTest extends TestCase
{
    public function testIfCreateInteger()
    {
        $integer = (new Integer())->equals(10);

        print_r($integer);

        $this->assertTrue(true);
    }
}