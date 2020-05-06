<?php

namespace App\Services\Caches;

use App\Models\Entity;
use App\Models\MiscModel;
use Illuminate\Support\Facades\Cache;

/**
 * Class EntityCacheService
 * @package App\Services\Caches
 */
class EntityCacheService extends BaseCache
{
    /**
     * In-memory entity cache
     * @var array
     */
    protected $entities = [];

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
        $key = $entity->type . '_' . $entity->entity_id;
        if (isset($this->entities[$key])) {
            return $this->entities[$key];
        }

        if ($entity->type == 'attribute_template') {
            $child = $entity->attributeTemplate;
        } elseif ($entity->type == 'dice_roll') {
            $child = $entity->diceRoll;
        } else {
            $child = $entity->{$entity->type};
        }

        return $this->entities[$key] = $child;
    }

//    /**
//     * @param int $id
//     * @return null|Entity
//     */
//    public function entity(int $id)
//    {
//        $key = $this->entityKey($id);
//        if ($this->user->isAdmin() && $this->has($key)) {
//            return $this->get($key);
//        }
//
//        $data = Entity::where(['id' => $id])->first();
//        $this->forever($key, $data);
//        return $data;
//    }
//
//    /**
//     * @param int $id
//     * @return bool
//     */
//    public function clearEntity(int $id): bool
//    {
//        return $this->forget(
//            $this->entityKey($id)
//        );
//    }
//
//    /**
//     * @param int $id
//     * @return string
//     */
//    protected function entityKey(int $id): string
//    {
//        return 'entity_' . $id;
//    }

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
