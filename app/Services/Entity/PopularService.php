<?php

namespace App\Services\Entity;

use App\Models\EntityType;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;

class PopularService
{
    use CampaignAware;
    use UserAware;

    public function get(): Collection
    {
        $types = new Collection;
        /** @var EntityType $entityType */
        foreach (EntityType::whereIn('id', $this->popularEntityIds())->get() as $entityType) {
            if (! $this->campaign->enabled($entityType)) {
                continue;
            } elseif (! $this->user->can('create', [$entityType, $this->campaign])) {
                continue;
            }
            $types->add($entityType);
        }

        return $types;
    }

    protected function popularEntityIds(): array
    {
        return [
            config('entities.ids.character'),
            config('entities.ids.location'),
            config('entities.ids.race'),
            config('entities.ids.item'),
            config('entities.ids.organisation'),
        ];
    }
}
