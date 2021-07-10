<?php

namespace TestBucket\Core\Specification;

use InvalidArgumentException;

class File
{
    private $path;

    public function __construct($path)
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException('File not exists at [' . $path . ']');
        }

        if (!is_readable($path)) {
            throw new InvalidArgumentException('Can not read this file: [' . $path . ']');
        }

        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getContents()
    {
        return file_get_contents($this->path);
    }
}
