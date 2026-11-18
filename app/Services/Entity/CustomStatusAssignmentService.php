<?php

namespace App\Services\Entity;

use App\Models\Campaign;
use App\Models\Entity;
use App\Models\EntityType;
use App\Rules\CategoryStatusAssignment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomStatusAssignmentService
{
    /**
     * Validate and persist a custom-category entity while holding the category
     * lock, so status definitions and assignments cannot race.
     */
    public function save(Entity $entity, callable $persist): mixed
    {
        if ($entity->exists && ! $entity->isDirty(['status_id', 'type_id', 'campaign_id'])) {
            return $persist();
        }

        $typeId = $entity->type_id;
        if (! $typeId || ! $entity->campaign_id || in_array((int) $typeId, config('entities.ids'), true)) {
            return $persist();
        }

        return DB::transaction(function () use ($entity, $persist, $typeId): mixed {
            $category = EntityType::whereKey($typeId)->lockForUpdate()->firstOrFail();
            if (! $category->isCustom()) {
                return $persist();
            }

            $campaign = Campaign::findOrFail($entity->campaign_id);
            if (! $entity->exists && ! array_key_exists('status_id', $entity->getAttributes()) && $campaign->premium()) {
                $entity->status_id = $category->statuses()
                    ->where('campaign_id', $campaign->id)
                    ->where('is_default', true)
                    ->value('id');
            }
            if ($entity->status_id !== null) {
                Validator::make(['status_id' => $entity->status_id], [
                    'status_id' => [new CategoryStatusAssignment($campaign, $category, $entity->exists ? $entity : null)],
                ])->validate();
            }

            return $persist();
        });
    }
}
