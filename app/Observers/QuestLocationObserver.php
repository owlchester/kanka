<?php

namespace App\Observers;

use App\Campaign;
use App\Models\QuestLocation;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class QuestLocationObserver
{
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
        $questLocation->description = Purify::clean($questLocation->description);
        $questLocation->description = $this->linkerService->parse($questLocation->description);
    }
}
