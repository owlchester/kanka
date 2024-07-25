<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Facades\Mentions;
use App\Facades\QuestCache;
use App\Models\QuestElement;

class QuestElementObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

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
}
