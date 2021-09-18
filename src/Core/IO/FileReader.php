<?php

namespace TestBucket\Core\IO;

use TestBucket\Core\Specification\Contracts\File;
use InvalidArgumentException;

class FileReader implements File
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
