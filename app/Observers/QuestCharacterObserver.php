<?php

namespace App\Observers;

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
        $questCharacter->description = $this->purify($questCharacter->description);
    }
}
