<?php
namespace TestBucket\Core\Domain\Concrete;

use TestBucket\Core\DataSource\DataSource;

/**
 * @deprecated
 */
class ConcreteDomain
{
    private $staticElements;

    public function __construct(DataSource $dt)
    {
        $this->staticElements = $dt->getAll();
    }

    public function has(Element $element) : bool
    {
        foreach ($this->staticElements as $oneElement) {
            if ($element->equals($oneElement)) {
                return true;
            }
        }
        return false;
    }

    public function isEmpty() : bool
    {
        return $this->staticElements->isEmpty();
    }

    public function getElements() : Collection
    {
        return $this->staticElements;
    }

    public function add(Domain $d)
    {
        if ($d->isEmpty()) {
            return;
        }

        foreach ($d->getElements() as $element) {
            $this->staticElements->add($element);
        }
    }

    public function subtract(Domain $d)
    {
        if ($d->isEmpty()) {
            return;
        }

        foreach ($d->getElements() as $externalElement) {
            foreach ($this->staticElements as $internalElement) {
                if ($externalElement->equals($internalElement)) {
                    $this->staticElements->remove($internalElement);
                }
            }
        }
    }

    public function intersect(Domain $d)
    {
        if ($d->isEmpty()) {
            return;
        }

        //$intersection = new ;

        foreach ($d->getElements() as $externalElement) {
            foreach ($this->staticElements as $internalElement) {
                if ($externalElement->equals($internalElement)) {
                    $this->staticElements->remove($internalElement);
                }
            }
        }
    }

    public function excludeIntersect(Domain $d)
    {
        if ($d->isEmpty()) {
            return;
        }
    }
}
