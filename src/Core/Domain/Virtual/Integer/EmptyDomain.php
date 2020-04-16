<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Virtual\Range;
use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;

class EmptyDomain implements Range
{
    public function __construct(ElementCalculable $start=null, ElementCalculable $end=null, ?int $precision=null)
    {

    }

    public function has(ElementInterface $element): bool
    {
        return false;
    }

    public function add(Range $domain): Range
    {
        return $domain;
    }

    public function subtract(Range $domain): Range
    {
        return $this;
    }

    public function getStartValue(): ElementCalculable
    {
        return new Element();
    }

    public function getEndValue(): ElementCalculable
    {
        return new Element();
    }

    public function countPartitions(): int
    {
        return 1;
    }

    public function reaches(Range $domain): bool
    {
        return !is_null($domain->getStartValue()) || !is_null($domain->getEndValue());
    }
}
