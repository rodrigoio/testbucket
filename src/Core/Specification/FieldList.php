<?php
declare(strict_types=1);

namespace App\Core\Specification;

use Iterator;

class FieldList
{
    private $list;

    public function __construct()
    {
        $this->list = new \ArrayObject();
    }

    public function add(Field $field) : void
    {
        $this->list->append($field);
    }

    public function get(int $index) : ?Field
    {
        if ($this->list->offsetExists($index)) {
            return $this->list->offsetGet($index);
        }
        return null;
    }

    public function set(Field $field, int $index) : void
    {
        if ($this->list->offsetExists($index)) {
            $this->list->offsetSet($index, $field);
        }
    }

    public function count() : int
    {
        return $this->list->count();
    }

    public function getIterator() : Iterator
    {
        return new FieldIterator($this);
    }
}
