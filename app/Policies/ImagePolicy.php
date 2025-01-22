<?php

namespace App\Policies;

use App\Facades\EntityPermission;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\Image;
use App\Models\User;

class ImagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {

    }

    public function browse(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY_BROWSE, $user, $campaign)
        );
    }

    public function create(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY_UPLOAD, $user, $campaign)
        );
    }

    public function view(?User $user, Image $image, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY_BROWSE, $user, $campaign) ||
                ($this->checkPermission(CampaignPermission::ACTION_GALLERY_UPLOAD, $user, $campaign) && $image->created_by === $user->id)
        );
    }
    public function edit(?User $user, Image $image, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                ($this->checkPermission(CampaignPermission::ACTION_GALLERY_UPLOAD, $user, $campaign) && $image->created_by === $user->id)
        );
    }

    public function delete(?User $user, Image $image, Campaign $campaign): bool
    {
        return $this->edit($user, $image, $campaign);
    }

    /**
     * @return bool
     */
    protected function checkPermission(int $action, User $user, ?Campaign $campaign = null)
    {
        return EntityPermission::campaign($campaign)->user($user)->hasPermission(0, $action, null);
    }
}
