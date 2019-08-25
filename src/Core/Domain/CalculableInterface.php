<?php
namespace App\Core\Domain;

interface CalculableInterface
{
    public function next();
    public function prev();
}