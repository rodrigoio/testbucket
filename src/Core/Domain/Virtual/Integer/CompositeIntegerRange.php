<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementInterface;
use App\Core\Domain\Virtual\Range;

class CompositeIntegerRange implements Range,Domain
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

    public function add(Domain $domain): Domain
    {
        // TODO: Implement add() method.
    }

    public function subtract(Domain $domain): Domain
    {
        // TODO: Implement subtract() method.
    }

    public function getStartValue() : ElementInterface
    {
        // TODO: Implement getStartValue() method.
    }

    public function getEndValue() : ElementInterface
    {
        // TODO: Implement getEndValue() method.
    }
}
