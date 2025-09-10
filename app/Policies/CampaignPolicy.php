<?php

namespace App\Policies;

use App\Facades\CampaignCache;
use App\Facades\EntityPermission;
use App\Facades\Identity;
use App\Models\Campaign;
use App\Models\CampaignPermission;
use App\Models\User;
use App\Traits\AdminPolicyTrait;
use Illuminate\Auth\Access\HandlesAuthorization;

class CampaignPolicy
{
    use AdminPolicyTrait;
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the campaign.
     */
    public function view(User $user, Campaign $campaign): bool
    {
        return $this->access($user, $campaign);
    }

    public function member(User $user, Campaign $campaign): bool
    {
        return CampaignCache::campaign($campaign)
                ->members()
                ->where('id', $user->id)->count() == 1;
    }

    /**
     * Determine whether the user can access the campaign
     */
    public function access(User $user, Campaign $campaign): bool
    {
        return true;
    }

    public function admin(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin($campaign);
    }

    /**
     * Can't create a campaign while impersonating another user. Should be handled in the controller?
     */
    public function create(User $user): bool
    {
        return ! Identity::isImpersonating();
    }

    /**
     * Determine whether the user can update the campaign.
     */
    public function update(User $user, Campaign $campaign): bool
    {
        return
            $this->member($user, $campaign) && (
                $user->isAdmin() || $this->checkPermission(CampaignPermission::ACTION_MANAGE, $user, $campaign)
            );
    }

    /**
     * Determine whether the user can manage the roles of the campaign.
     */
    public function roles(User $user, Campaign $campaign): bool
    {
        return
            $this->member($user, $campaign) && (
                $user->isAdmin()
            );
    }

    /**
     * Determine whether the user can manage the webhooks of the campaign.
     */
    public function webhooks(User $user, Campaign $campaign): bool
    {
        return $this->recover($user, $campaign);
    }

    /**
     * Determine whether the user can manage the webhooks of the campaign.
     */
    public function logs(User $user, Campaign $campaign): bool
    {
        return $this->recover($user, $campaign);
    }

    /**
     * Determine whether the user can delete the campaign.
     */
    public function delete(User $user, Campaign $campaign): bool
    {
        return
            $this->member($user, $campaign) &&
            $user->isAdmin() &&
            CampaignCache::campaign($campaign)->members()->count() == 1;
    }

    public function invite(User $user, Campaign $campaign): bool
    {
        return $this->member($user, $campaign) && (
            $user->isAdmin() || $this->checkPermission(CampaignPermission::ACTION_MEMBERS, $user, $campaign)
        );
    }

    public function setting(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin();
    }

    public function recover(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin($campaign);
    }

    public function history(User $user, Campaign $campaign): bool
    {
        return $this->recover($user, $campaign);
    }

    public function dashboard(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin() || $this->checkPermission(CampaignPermission::ACTION_DASHBOARD, $user, $campaign);
    }

    public function stats(User $user, Campaign $campaign): bool
    {
        return $this->member($user, $campaign);
    }

    public function search(User $user, Campaign $campaign): bool
    {
        return $user->isAdmin();
    }

    public function import(User $user, Campaign $campaign): bool
    {
        return $user->isWyvern() || $user->isElemental() || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can leave the campaign
     */
    public function leave(User $user, Campaign $campaign): bool
    {
        if (Identity::isImpersonating()) {
            return false;
        }
        if (!$this->member($user, $campaign)) {
            return false;
        }

        // If we are not the owner
        if (!$user->isAdmin()) {
            return true;
        }

        // If there are other admins
        return $campaign->roles()
                ->admin()
                ->first()
                ->users
                ->count() > 1;
    }

    /**
     * Determine if a user can follow a campaign
     */
    public function follow(User $user, Campaign $campaign): bool
    {
        if (! $campaign->isPublic()) {
            return false;
        }

        return ! $this->member($user, $campaign);
    }

    /**
     * Determine if a user can apply to a campaign
     */
    public function apply(User $user, Campaign $campaign): bool
    {
        if (! $campaign->isPublic() || ! $campaign->is_open) {
            return false;
        }

        return ! $this->member($user, $campaign);
    }

    /**
     * Permission to view the members of a campaign
     */
    public function members(User $user, Campaign $campaign): bool
    {
        return ($user->isAdmin($campaign) || $this->checkPermission(CampaignPermission::ACTION_MEMBERS, $user, $campaign)) ||
            ! ($campaign->boosted() && $campaign->hide_members);
    }

    /**
     * Permission to view the campaign applications
     */
    public function applications(?User $user): bool
    {
        return $user && $user->isAdmin();
    }

    public function gallery(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
            $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
            $this->checkPermission(CampaignPermission::ACTION_GALLERY_BROWSE, $user, $campaign)
        );
    }

    public function relations(?User $user): bool
    {
        return $user && $user->isAdmin();
    }

    public function mapPresets(?User $user): bool
    {
        return $user && $user->isAdmin();
    }

    /**
     * Check if a user can unboost a campaign
     */
    public function unboost(?User $user, Campaign $campaign): bool
    {
        $boost = $campaign->boosts->first();

        return $user && $boost && $boost->user_id === $user->id;
    }

    public function galleryManage(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign)
        );
    }

    public function galleryBrowse(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY_BROWSE, $user, $campaign)
        );
    }

    public function galleryUpload(?User $user, Campaign $campaign): bool
    {
        return $user && (
            $user->isAdmin() ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY, $user, $campaign) ||
                $this->checkPermission(CampaignPermission::ACTION_GALLERY_UPLOAD, $user, $campaign)
        );
    }

    protected function checkPermission(int $action, User $user, ?Campaign $campaign = null): bool
    {
        return EntityPermission::campaign($campaign)->user($user)->hasPermission(0, $action, null);
    }

    /**
     * Determine if the user can use templates on the campaign
     */
    public function useTemplates(?User $user, Campaign $campaign): bool
    {
        return true;
    }

    /**
     * Determine if the user can set templates on the campaign
     */
    public function setTemplates(?User $user, Campaign $campaign): bool
    {
        return $this->isAdmin($user) || $this->checkPermission(CampaignPermission::ACTION_TEMPLATES, $user, $campaign);
    }

    /**
     * Determine if the user can set post templates on the campaign
     */
    public function setPostTemplates(?User $user, Campaign $campaign): bool
    {
        return $this->isAdmin($user) || $this->checkPermission(CampaignPermission::ACTION_POST_TEMPLATES, $user, $campaign);
    }

    public function export(User $user, Campaign $campaign): bool
    {
        if (! app()->isProduction()) {
            return true;
        }
        if ($user->hasRole('admin')) {
            return true;
        }

        return empty($campaign->export_date) || ! $campaign->export_date->isToday() && $campaign->queuedCampaignExports->count() === 0;
    }
}
