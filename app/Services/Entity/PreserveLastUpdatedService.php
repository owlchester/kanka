<?php

namespace App\Services\Entity;

use App\Models\Entity;
use Illuminate\Support\Facades\DB;

class PreserveLastUpdatedService
{
    /**
     * Capture the values shown as the entity's last update information.
     */
    public function snapshot(Entity $entity): array
    {
        $snapshot = [
            'updated_at' => $entity->getRawOriginal('updated_at'),
        ];

        if (array_key_exists('updated_by', $entity->getAttributes())) {
            $snapshot['updated_by'] = $entity->getRawOriginal('updated_by');
        }

        return $snapshot;
    }

    /**
     * Restore the captured values without firing model events or changing logs.
     *
     * The current timestamp is part of the update condition so a concurrent
     * update is not overwritten by a stealth edit.
     */
    public function restore(Entity $entity, array $snapshot): void
    {
        if (! $entity->exists) {
            return;
        }

        $table = $entity->getTable();
        $key = $entity->getKeyName();
        $current = DB::table($table)
            ->where($key, $entity->getKey())
            ->first(array_keys($snapshot));

        if ($current === null || $this->matches($current, $snapshot)) {
            return;
        }

        $query = DB::table($table)->where($key, $entity->getKey());
        if ($current->updated_at === null) {
            $query->whereNull('updated_at');
        } else {
            $query->where('updated_at', $current->updated_at);
        }

        if ($query->update($snapshot) === 0) {
            return;
        }

        foreach ($snapshot as $attribute => $value) {
            $entity->setAttribute($attribute, $value);
        }
        $entity->syncOriginalAttributes(array_keys($snapshot));
    }

    private function matches(object $current, array $snapshot): bool
    {
        foreach ($snapshot as $attribute => $value) {
            if (! $this->sameValue($current->{$attribute}, $value)) {
                return false;
            }
        }

        return true;
    }

    private function sameValue(mixed $current, mixed $original): bool
    {
        if ($current === null || $original === null) {
            return $current === $original;
        }

        return (string) $current === (string) $original;
    }
}
