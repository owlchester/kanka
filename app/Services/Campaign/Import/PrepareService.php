<?php

namespace App\Services\Campaign\Import;

use App\Enums\CampaignImportStatus;
use App\Models\CampaignImport;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class PrepareService
{
    use CampaignAware;
    use UserAware;

    public function token(): CampaignImport
    {
        $token = CampaignImport::where('campaign_id', $this->campaign->id)
            ->where('user_id', $this->user->id)
            ->whereNotIn('status_id', [CampaignImportStatus::FINISHED, CampaignImportStatus::FAILED, CampaignImportStatus::READY])
            ->first();
        if ($token) {
            return $token;
        }

        $token = new CampaignImport;
        $token->user_id = $this->user->id;
        $token->campaign_id = $this->campaign->id;
        $token->status_id = CampaignImportStatus::PREPARED;
        $token->save();

        return $token;
    }
}
