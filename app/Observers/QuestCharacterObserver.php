<?php

namespace App\Observers;

use App\Campaign;
use App\Models\QuestCharacter;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class QuestCharacterObserver
{
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
        $questCharacter->description = Purify::clean($questCharacter->description);
        $questCharacter->description = $this->linkerService->parse($questCharacter->description);
    }
}
