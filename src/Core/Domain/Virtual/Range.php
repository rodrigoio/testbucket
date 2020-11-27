<?php
declare(strict_types=1);

namespace TestBucket\Core\Domain\Virtual;

use TestBucket\Core\Domain\Domain;
use TestBucket\Core\Domain\ElementCalculable;
use TestBucket\Core\Domain\Virtual\Integer\IntegerRangeList;

interface Range extends Domain
{
    public function __construct(ElementCalculable $start, ElementCalculable $end, ?int $precision);

    public function union(Range $domain) : IntegerRangeList;

    public function difference(Range $domain) : IntegerRangeList;

    public function reaches(Range $domain) : bool;

    public function equals(Range $domain) : bool;

    public function getStartValue() : ?ElementCalculable;

    public function getEndValue() : ?ElementCalculable;
}
