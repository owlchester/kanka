<?php

namespace App\Services\Caches\Traits;

use Illuminate\Support\Collection;

trait PrimaryCache
{
    /**
     * Cached primary data
     */
    protected array $primary = [];

    protected function primary(int $cache): Collection
    {
        if (isset($this->primary[$cache])) {
            return $this->primary[$cache];
        }

        $key = $this->primaryKey();
        if ($this->has($key)) {
            return $this->primary[$cache] = new Collection($this->get($key));
        }

        $data = $this->primaryData();

        $this->forever($key, $data);

        return $this->primary[$cache] = new Collection($data);
    }

    /**
     * Clear the primary cache
     */
    public function clear(): self
    {
        $this->forget($this->primaryKey());

        return $this;
    }

    /**
     * Some data needs to load "after the init", which can be done with this append function.
     */
    protected function append(int $key, string $property, mixed $data): mixed
    {
        $this->primary[$key][$property] = $data;
        $this->forever($this->primaryKey(), $this->primary[$key]);

        return $data;
    }
}
