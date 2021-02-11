<?php

namespace App\Observers;

use App\Models\CampaignSubmission;

class CampaignSubmissionObserver
{
    use PurifiableTrait;

    public function saving(CampaignSubmission $campaignSubmission)
    {
        $campaignSubmission->text = $this->purify($campaignSubmission->text);
    }
}
