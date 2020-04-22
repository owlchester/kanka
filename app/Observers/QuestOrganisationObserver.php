<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\QuestOrganisation;

class QuestOrganisationObserver
{
    /**
     * Purify trait
     */
    use PurifiableTrait;

    /**
     * @param QuestOrganisation $questOrganisation
     */
    public function saving(QuestOrganisation $questOrganisation)
    {
        $questOrganisation->description = $this->purify(Mentions::codify($questOrganisation->description));
    }
}
