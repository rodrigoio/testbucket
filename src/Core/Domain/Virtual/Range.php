<?php
declare(strict_types=1);

namespace App\Core\Domain\Virtual;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementCalculable;

interface Range extends Domain
{
    public function __construct(?ElementCalculable $start, ?ElementCalculable $end, ?int $precision);

    public function add(Range $domain);

    public function subtract(Range $domain);

    public function reaches(Range $domain) : bool;

    public function countPartitions() : int;

    public function getStartValue() : ?ElementCalculable;

    public function getEndValue() : ?ElementCalculable;
}
