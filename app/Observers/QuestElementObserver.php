<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Facades\Mentions;
use App\Facades\QuestCache;
use App\Models\QuestElement;
use App\Services\EntityMappingService;

class QuestElementObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     */
    protected EntityMappingService $entityMappingService;


    /**
     * CharacterObserver constructor.
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     */
    public function saving(QuestElement $questElement)
    {
        $questElement->description = $this->purify(Mentions::codify($questElement->description));
        $questElement->role = $this->purify($questElement->role);
        $questElement->name = $this->purify($questElement->name);

        if (empty($questElement->visibility_id)) {
            $questElement->visibility_id = Visibility::All;
        }
    }

    /**
     */
    public function saved(QuestElement $questElement)
    {
        // If the quest element's entry has changed, we need to re-build it's map.
        if ($questElement->isDirty('description')) {
            $this->entityMappingService->mapQuestElement($questElement);
        }
        QuestCache::clearSuggestion();
    }
}
