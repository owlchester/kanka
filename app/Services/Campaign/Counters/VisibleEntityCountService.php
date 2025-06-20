<?php

namespace App\Services\Campaign\Counters;

use App\Enums\Permission;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Traits\CampaignAware;

class VisibleEntityCountService
{
    use CampaignAware;

    protected CampaignRole $role;

    protected int $count;

    protected array $types;

    protected array $ids;

    public function process(): void
    {
        $this
            ->role()
            ->permissions()
            ->count()
            ->save()
            ->cleanup();
    }

    protected function role(): self
    {
        $this->role = CampaignRole::where([
            'campaign_id' => $this->campaign->id,
            'is_public' => true,
        ])
            ->with('permissions')
            ->first();

        return $this;
    }

    protected function permissions(): self
    {
        $this->types = $this->ids = [];
        /** @var CampaignPermission $permission */
        foreach ($this->role->permissions as $permission) {
            if ($permission->isAction(Permission::View->value)) {
                if (! empty($permission->entity_id)) {
                    $this->ids[] = $permission->entity_id;
                } else {
                    $this->types[] = $permission->entity_type_id;
                }
            }
        }

        return $this;
    }

    protected function count(): self
    {
        // Now that we have the types and ids, we can count the number of visible entities in this campaign
        $this->count = Entity::where(['campaign_id' => $this->campaign->id])
            ->where('is_private', false)
            ->where(function ($sub) {
                return $sub->inTypes($this->types)
                    ->orWhereIn('id', $this->ids);
            })
            ->count();

        return $this;
    }

    protected function save(): self
    {
        $this->campaign->visible_entity_count = $this->count;
        $this->campaign->saveQuietly();

        return $this;
    }

    protected function cleanup(): void
    {
        unset($this->count);
        unset($this->campaign);
        unset($this->role);
        unset($this->ids);
        unset($this->types);
    }
}
