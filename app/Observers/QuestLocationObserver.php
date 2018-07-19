<?php

namespace App\Observers;

use App\Models\QuestLocation;
use App\Services\LinkerService;

class QuestLocationObserver
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
     * LocationObserver constructor.
     * @param LinkerService $linkerService
     */
    public function __construct(LinkerService $linkerService)
    {
        $this->linkerService = $linkerService;
    }

    /**
     * @param QuestLocation $questLocation
     */
    public function saving(QuestLocation $questLocation)
    {
        $questLocation->description = $this->purify($questLocation->description);
        $questLocation->description = $this->linkerService->parse($questLocation->description);
    }
}
