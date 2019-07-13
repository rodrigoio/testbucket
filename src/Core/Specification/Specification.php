<?php
namespace App\Specification;

interface Specification
{
    public function add($inputName, InputSpecification $inputSpec);
    public function getDomain($inputName);
    public function getOuterDomain($inputName);
}