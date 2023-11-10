<?php

namespace App\Services\Campaign\Import;

class ImportIdMapper
{
    protected array $misc = [];
    protected array $entities = [];
    protected array $gallery = [];

    public function put(string $type, int $old, int $new): self
    {
        $this->misc[$type][$old] = $new;
        return $this;
    }

    public function putEntity(int $old, int $new): self
    {
        $this->entities[$old] = $new;
        return $this;
    }

    public function putGallery(string $old, string $new): self
    {
        $this->gallery[$old] = $new;
        return $this;
    }

    public function get(string $type, int $old): int
    {
        return $this->misc[$type][$old];
    }

    public function getEntity(string $type, int $old): int
    {
        return $this->entities[$type][$old];
    }

    public function getGallery(string $old): string
    {
        return $this->gallery[$old];
    }
}
