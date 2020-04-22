<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Integer\IntegerRangeList;

interface Range extends Domain
{
    public function __construct(?ElementCalculable $start, ?ElementCalculable $end, ?int $precision);

    public function union(Range $domain) : IntegerRangeList;

    public function difference(Range $domain) : IntegerRangeList;

    public function reaches(Range $domain) : bool;

    public function getStartValue() : ?ElementCalculable;

    public function getEndValue() : ?ElementCalculable;
}
