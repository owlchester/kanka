<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\QuestCharacter;

class QuestCharacterObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param QuestCharacter $questCharacter
     */
    public function saving(QuestCharacter $questCharacter)
    {
        $questCharacter->description = $this->purify(Mentions::codify($questCharacter->description));
    }
}
