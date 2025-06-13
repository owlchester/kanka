<?php

namespace App\Events\Campaigns\Members;

use App\Models\CampaignRoleUser;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUserRemoved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public CampaignRoleUser $campaignRoleUser, )
    {
        //
    }
}
