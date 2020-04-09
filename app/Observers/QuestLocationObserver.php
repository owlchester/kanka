<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\QuestLocation;

class QuestLocationObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param QuestLocation $questLocation
     */
    public function saving(QuestLocation $questLocation)
    {
        $questLocation->description = $this->purify(Mentions::codify($questLocation->description));
    }
}
