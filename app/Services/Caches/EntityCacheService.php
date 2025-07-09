<?php

namespace App\Services\Caches;

use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * Class EntityCacheService
 */
class EntityCacheService extends BaseCache
{
    use CampaignAware;

    /**
     * In-memory entity cache
     */
    protected array $entities = [];

    public function typeSuggestion(EntityType $entityType): array
    {
        return Cache::remember($this->typeSuggestionKey($entityType->code), 24 * 3600, function () use ($entityType) {
            return Entity::select(DB::raw('type, MAX(created_at) as cmat'))
                ->groupBy('type')
                ->whereNotNull('type')
                ->where('type_id', $entityType->id)
                ->orderBy('cmat', 'DESC')
                ->take(20)
                ->pluck('type')
                ->all();
        });
    }

    public function clearSuggestion(EntityType $entityType): self
    {
        $this->forget(
            $this->typeSuggestionKey(
                $entityType->code
            )
        );

        return $this;
    }

    /**
     * @return MiscModel|mixed
     */
    public function child(Entity $entity)
    {
        $key = $entity->type_id . '_' . $entity->entity_id;
        if (isset($this->entities[$key])) {
            return $this->entities[$key];
        }

        // Why are we doing ->first? because child is a loop to this function.
        $child = $entity->child()->first();

        return $this->entities[$key] = $child;
    }

    /**
     * Type suggestion cache key
     */
    protected function typeSuggestionKey(string $type): string
    {
        return 'campaign_' . $this->campaign->id . '_' . $type . '_type_suggestions';
    }
}
