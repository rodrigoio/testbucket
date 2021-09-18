<?php

declare(strict_types=1);

namespace TestBucket\Core\BoundaryValue\Virtual\Contracts;

interface RangeSet extends Domain
{
    public function applyUnion(Range $outerDomain) : void;
    public function applyDifference(Range $outerDomain) : void;
    public function oppositeSet() : RangeSet;
    public function getRangeList(): RangeList;
}
