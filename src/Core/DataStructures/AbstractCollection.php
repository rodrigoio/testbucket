<?php
namespace TestBucket\Core\DataStructures;

class AbstractCollection implements Collection
{
    protected $list;

    public function __construct(array $data=[])
    {
        $this->list = new \ArrayObject($data);
    }

    public function isEmpty() : bool
    {
        return $this->list->getIterator()->count() <= 0;
    }

    public function add($e) : void
    {
        $this->list->append($e);
    }

    public function remove($e) : void
    {

    }

    public function getIterator(): \ArrayIterator
    {
        return $this->list->getIterator();
    }
}
