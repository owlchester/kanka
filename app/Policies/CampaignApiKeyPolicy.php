<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CampaignApiKey;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignApiKeyPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    public function delete(User $user, CampaignApiKey $apiKey): bool
    {
        return $user->isAdmin();
    }
}
