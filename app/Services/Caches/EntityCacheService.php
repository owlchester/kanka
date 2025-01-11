<?php

namespace App\Services\Caches;

use App\Models\Entity;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Support\Facades\Cache;

/**
 * Class EntityCacheService
 * @package App\Services\Caches
 */
class EntityCacheService extends BaseCache
{
    use CampaignAware;

    /**
     * In-memory entity cache
     */
    protected array $entities = [];

    /**
     */
    public function typeSuggestion(EntityType $entityType): array
    {
        $key = $this->typeSuggestionKey($entityType->code);
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = $entityType->getClass()->entityTypeSuggestion();

        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
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
