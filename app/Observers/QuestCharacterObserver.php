<?php

namespace App\Observers;

use App\Campaign;
use App\Models\QuestCharacter;
use App\Services\LinkerService;

class QuestCharacterObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @var LinkerService
     */
    protected $linkerService;

    /**
     * CharacterObserver constructor.
     * @param LinkerService $linkerService
     */
    public function __construct(LinkerService $linkerService)
    {
        $this->linkerService = $linkerService;
    }

    /**
     * @param QuestCharacter $questCharacter
     */
    public function saving(QuestCharacter $questCharacter)
    {
        $questCharacter->description = $this->purify($questCharacter->description);
        $questCharacter->description = $this->linkerService->parse($questCharacter->description);
    }
}
