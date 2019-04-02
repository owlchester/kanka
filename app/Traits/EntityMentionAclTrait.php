<?php

namespace App\Traits;

use App\Facades\UserPermission;

/**
 * Trait EntityAclTrait
 * @package App\Traits
 *
 * Todo: Refactor for less calls on each page load. Cache results? To session? Do the logic in php?
 * Load all "item" and "items" on calls and loop through the results?
 * At least cache the roles.
 */
trait EntityMentionAclTrait
{
    /**
     * Scope a query to only include elements that are visible
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEntityAcl($query, $action = 'read', $user = null)
    {
        // Use the User Permission Service to handle all of this easily.
        /** @var \App\Services\UserPermission $service */
        $service = UserPermission::user($user)->action($action);

        if ($service->isCampaignOwner()) {
            return $query;
        }

        return $query
            ->select('entity_mentions.*')
            ->join('entities', 'entities.id', '=', 'entity_mentions.entity_id')
            ->where('entities.is_private', false)
            ->where(function ($subquery) use ($service) {
                return $subquery
                    ->whereIn('entities.id', $service->entityIds())
                    ->orWhereIn('entities.type', $service->entityTypes());
            });
    }

    /**
     * @param $query
     * @param string $action
     * @param null $user
     * @return mixed
     */
    public function scopeEntityNoteAcl($query, $action = 'read', $user = null)
    {
        // Use the User Permission Service to handle all of this easily.
        /** @var \App\Services\UserPermission $service */
        $service = UserPermission::user($user)->action($action);

        if ($service->isCampaignOwner()) {
            return $query;
        }

        return $query
            ->select('entity_mentions.*')
            ->join('entity_notes', 'entity_notes.id', '=', 'entity_mentions.entity_note_id')
            ->join('entities', 'entities.id', '=', 'entity_notes.entity_id')
            ->where('entities.is_private', false)
            ->where('entity_notes.is_private', false)
            ->where(function ($subquery) use ($service) {
                return $subquery
                    ->whereIn('entities.id', $service->entityIds())
                    ->orWhereIn('entities.type', $service->entityTypes());
            });
    }
}
