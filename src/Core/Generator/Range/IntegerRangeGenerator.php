<?php
namespace App\Core\Generator\Range;

use App\Core\Domain\Virtual\Range\Range;
use App\Core\Generator\Result\CaseResult;
use App\Core\Generator\Result\CaseCollection;

class IntegerRangeGenerator
{
    const SIGNATURE = 'INT_RAN_GEN';

    private $range;

    public function __construct(Range $range)
    {
        $this->range = $range;
    }

    public function generate()
    {
        $startValue= $this->range->getStartValue();
        $endValue  = $this->range->getEndValue();

        //TODO - we need a better solution, soon.
        $case1 = new CaseResult(self::SIGNATURE, [$startValue, $endValue],true);
        $case2 = new CaseResult(self::SIGNATURE, [$startValue, $endValue-1],true);
        $case3 = new CaseResult(self::SIGNATURE, [$startValue+1, $endValue],true);

        //TODO - at this point we need apply fail cases combination, but not hard coded like this.
        //this commit is just a basement. to start in the combination strategy
        $case4 = new CaseResult(self::SIGNATURE, [$startValue-1, $endValue],false);
        $case5 = new CaseResult(self::SIGNATURE, [$startValue, $endValue+1],false);
        $case6 = new CaseResult(self::SIGNATURE, [$startValue-1, $endValue+1],false);

        $result = new CaseCollection();
        $result->add($case1);
        $result->add($case2);
        $result->add($case3);
        $result->add($case4);
        $result->add($case5);
        $result->add($case6);

        return $result;
    }
}
