<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Facades\QuestCache;
use App\Models\QuestElement;
use App\Models\Visibility;
use App\Services\EntityMappingService;
use App\Traits\VisibilityIDTrait;

class QuestElementObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * Service used to build the map of the entity
     * @var EntityMappingService
     */
    protected $entityMappingService;


    /**
     * CharacterObserver constructor.
     * @param EntityMappingService $entityMappingService
     */
    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    /**
     * @param QuestElement $questElement
     */
    public function saving(QuestElement $questElement)
    {
        $questElement->description = $this->purify(Mentions::codify($questElement->description));
        $questElement->role = $this->purify($questElement->role);
        $questElement->name = $this->purify($questElement->name);

        if (empty($questElement->visibility_id)) {
            $questElement->visibility_id = Visibility::VISIBILITY_ALL;
        }
    }

    /**
     * @param QuestElement $questElement
     */
    public function creating(QuestElement $questElement)
    {
        $questElement->created_by = auth()->user()->id;
    }

    /**
     * @param QuestElement $questElement
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
