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
        // Read the cache once. A separate has()/get() pair can race with cache
        // expiry or invalidation and turn a missing value into an empty
        // collection that then gets persisted by append().
        $data = $this->get($key);
        if ($data instanceof Collection) {
            $data = $data->all();
        }
        if (is_array($data) && $data !== []) {
            return $this->primary[$cache] = new Collection($data);
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
        $this->primary = [];

        return $this;
    }

    /**
     * Some data needs to load "after the init", which can be done with this append function.
     */
    protected function append(int $key, string $property, mixed $data): mixed
    {
        $primary = $this->primary[$key];
        $primary[$property] = $data;
        $this->forever($this->primaryKey(), $primary->all());

        return $data;
    }
}
