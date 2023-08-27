<?php

namespace App\Services\Caches;

use App\Models\Entity;
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
     * @var array
     */
    protected array $entities = [];

    /**
     * @param MiscModel $model
     * @return array
     */
    public function typeSuggestion(MiscModel $model): array
    {
        $key = $this->typeSuggestionKey($model->getEntityType());
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        $data = $model->entityTypeSuggestion();


        Cache::put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @param MiscModel $model
     * @return $this
     */
    public function clearSuggestion(MiscModel $model): self
    {
        $this->forget(
            $this->typeSuggestionKey(
                $model->getEntityType()
            )
        );
        return $this;
    }

    /**
     * @param Entity $entity
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
     * @param string $type
     * @return string
     */
    protected function typeSuggestionKey(string $type): string
    {
        return 'campaign_' . $this->campaign->id . '_' . $type . '_type_suggestions';
    }
}
