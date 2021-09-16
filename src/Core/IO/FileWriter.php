<?php

namespace TestBucket\Core\IO;

class FileWriter
{
    /**
     * @var string
     */
    private $path;
    /**
     * @var false|resource
     */
    private $resource;

    public function __construct(string $path)
    {
        $this->path = $path;
        $this->resource = fopen($this->path, 'w');
    }

    public function write($contents)
    {
        fwrite($this->resource, $contents . "\n");
    }

    public function __destruct()
    {
        if (is_resource($this->resource))
            fclose($this->resource);
    }
}
