<?php

namespace App\Observers;

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
        $questLocation->description = $this->purify($questLocation->description);
    }
}
