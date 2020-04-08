<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\QuestItem;

class QuestItemObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param QuestItem $questItem
     */
    public function saving(QuestItem $questItem)
    {
        $questItem->description = $this->purify(Mentions::codify($questItem->description));
    }
}
