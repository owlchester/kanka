<?php

namespace App\Services\Caches\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait PrimaryCache
{
    /**
     * Cached primary data
     */
    protected Collection $primary;

    protected function primary(): Collection
    {
        if (isset($this->primary)) {
            return $this->primary;
        }

        $key = $this->primaryKey();
        if ($this->has($key)) {
            return $this->primary = new Collection($this->get($key));
        }

        $data = $this->primaryData();

        $this->forever($key, $data);
        return $this->primary = new Collection($data);
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
     * @param string $key
     * @param mixed $data
     * @return mixed
     */
    protected function append(string $key, mixed $data): mixed
    {
        $this->primary[$key] = $data;
        $this->forever($this->primaryKey(), $this->primary);
        return $data;
    }
}
