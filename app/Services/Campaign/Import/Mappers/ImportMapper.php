<?php

namespace App\Services\Campaign\Import\Mappers;

trait ImportMapper
{
    protected array $data;

    protected string $path;

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function path(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function prepare(): self
    {
        return $this;
    }

    public function clear(): void
    {
        unset($this->path, $this->data);
    }
}
