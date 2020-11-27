<?php
namespace TestBucket\Core\Generator\Result;

class CaseResult
{
    protected $type;
    protected $data;
    protected $success;

    public function __construct(string $type, array $data, bool $success=false)
    {
        $this->type     = $type;
        $this->data     = $data;
        $this->success  = $success;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function isSuccess(): bool
    {
        return $this->success;
    }
}
