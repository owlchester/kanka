<?php

namespace App\Services\Caches;

use App\Models\MiscModel;
use Illuminate\Support\Facades\Cache;

/**
 * Class EntityCacheService
 * @package App\Services\Caches
 */
class EntityCacheService extends BaseCache
{
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
     * Type suggestion cache key
     * @param MiscModel $model
     * @return string
     */
    protected function typeSuggestionKey(string $type): string
    {
        return 'campaign_' . $this->campaign->id . '_' . $type . '_type_suggestions';
    }
}
