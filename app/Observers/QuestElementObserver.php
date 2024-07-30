<?php

namespace App\Observers;

use App\Enums\Visibility;
use App\Facades\Mentions;
use App\Models\QuestElement;

class QuestElementObserver
{
    /**
     */
    public function saving(QuestElement $questElement)
    {
        if (empty($questElement->visibility_id)) {
            $questElement->visibility_id = Visibility::All;
        }
    }
}
