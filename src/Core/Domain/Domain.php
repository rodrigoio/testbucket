<?php
namespace App\Core\Domain;

interface Domain
{
    public function has(ElementInterface $element) : bool;

    public function add(Domain $domain) : Domain;

    public function subtract(Domain $domain) : Domain;
}
