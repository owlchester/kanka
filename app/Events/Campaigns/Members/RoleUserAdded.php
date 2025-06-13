<?php

namespace App\Events\Campaigns\Members;

use App\Models\CampaignRoleUser;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUserAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(
        public CampaignRoleUser $campaignRoleUser,
        public ?User $user,
    ) {
        //
    }
}
