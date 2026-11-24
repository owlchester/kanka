<?php

namespace App\Services\Caches\Traits;

use ArrayObject;
use Illuminate\Support\Collection;

trait PrimaryCache
{
    /**
     * Shared per-request primary cache store (kept as an ArrayObject so cloned
     * scoped instances share invalidations cleanly).
     *
     * @var ArrayObject<int, Collection<string, mixed>>|null
     */
    protected ?ArrayObject $primary = null;

    /**
     * @return ArrayObject<int, Collection<string, mixed>>
     */
    protected function primaryStore(): ArrayObject
    {
        return $this->primary ??= new ArrayObject;
    }

    protected function primary(int $cache): Collection
    {
        $store = $this->primaryStore();
        if (isset($store[$cache])) {
            return $store[$cache];
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
            return $store[$cache] = new Collection($data);
        }

        $data = $this->primaryData();

        $this->forever($key, $data);

        return $store[$cache] = new Collection($data);
    }

    /**
     * Clear the primary cache
     */
    public function clear(): self
    {
        $this->forget($this->primaryKey());
        $this->primaryStore()->exchangeArray([]);

        return $this;
    }

    /**
     * Some data needs to load "after the init", which can be done with this append function.
     */
    protected function append(int $key, string $property, mixed $data): mixed
    {
        $primary = $this->primaryStore()[$key];
        $primary[$property] = $data;
        $this->forever($this->primaryKey(), $primary->all());

        return $data;
    }
}
