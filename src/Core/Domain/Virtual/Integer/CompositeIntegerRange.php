<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementInterface;
use App\Core\Domain\ElementCalculable;
use App\Core\Domain\Virtual\Range;

class CompositeIntegerRange implements Domain,Range
{
    protected $startValue;
    protected $endValue;
    protected $domains;

    public function __construct(\ArrayObject $domains)
    {
        $this->domains = $domains;
    }

    public function has(ElementInterface $element): bool
    {
        foreach ($this->domains as $domain) {
            if ($domain->has($element)) {
                return true;
            }
        }
        return false;
    }

    public function size()
    {
        return count( $this->domains );
    }

    public function add(Domain $domain): Domain
    {
        // TODO: Implement add() method.
    }

    public function subtract(Domain $domain): Domain
    {
        // TODO: Implement subtract() method.
    }

    public function getStartValue() : ElementCalculable
    {
        // TODO: Implement getStartValue() method.
    }

    public function getEndValue() : ElementCalculable
    {
        // TODO: Implement getEndValue() method.
    }
}