<?php
namespace App\Core\Domain\Virtual\Integer;

use App\Core\Domain\Domain;
use App\Core\Domain\ElementInterface;

class Integer implements Domain
{
    private $element;

    public function __construct(ElementInterface $element)
    {
        $this->element = $element;
    }

    public function has(ElementInterface $element): bool
    {
        return $this->element->equals($element);
    }

    public function add(Domain $domain): Domain
    {
        // TODO: Implement add() method.
        // the exact next one, will result a range: 1-2
        // otherwise will result a composed domain: 1, 5  (the 2,3 and 4 are not in this domain)
    }

    public function subtract(Domain $domain): Domain
    {
        // TODO: Implement subtract() method.
        // subtract it itself will result null...
        // subtract any other value will result itself
    }

    public function intersect(Domain $domain): Domain
    {
        // TODO: Implement intersect() method.
        // intersect with itself will result the same value
        // otherwise will result in null
    }

    public function excludeIntersect(Domain $domain): Domain
    {
        // TODO: Implement excludeIntersect() method.
        // if receive the exact value, will result null
        // if receive a range will exclude only his value from the combined domain.
        //  -- this operation can result in a unity, a range, or a composed domain.
    }
}
