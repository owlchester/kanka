<?php

namespace App\Services\Campaign;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Http\Requests\API\UpdateUserRole;
use App\Models\Campaign;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\User;

class MemberService
{
    /** @var Campaign */
    protected $campaign;

    /** @var User */
    protected $user;

    /** @var CampaignRole */
    protected $campaignRole;

    /** @var CampaignRoleUser|null */
    protected $userCampaignRole;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    public function element(CampaignRoleUser $campaignRoleUser): self
    {
        $this->userCampaignRole = $campaignRoleUser;
        return $this;
    }

    public function user(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param UpdateUserRole $request
     * @return $this
     */
    public function fromRequest(UpdateUserRole $request): self
    {
        $this
            ->loadUser($request->get('user_id'))
            ->loadCampaignRole($request->get('role_id'));

        return $this;
    }

    /**
     * @param CampaignUser $user
     * @param CampaignRole $campaignRole
     * @return bool
     */
    public function update(CampaignUser $user, CampaignRole $campaignRole): bool
    {
        /** @var CampaignRoleUser|null $role */
        $role = CampaignRoleUser::where('user_id', $user->user_id)
            ->where('campaign_role_id', $campaignRole->id)
            ->first();

        // Admin role being switched? Forget the cache
        if ($campaignRole->isAdmin()) {
            CampaignCache::campaign($campaignRole->campaign)->clearAdmins();
        }

        // Deleting an existing role
        if ($role) {
            if ($role->campaignRole->isAdmin() && !$role->recentlyCreated()) {
                throw (new TranslatableException(
                    'campaigns.roles.users.errors.cant_kick_admins'
                ))->setOptions([
                    'admin' => $role->campaignRole->name,
                    'discord' => link_to(config('social.discord'), 'Discord'),
                    'email' => link_to('mailto:' . config('app.email'), config('app.email'))
                ]);
            }
            $role->delete();
            return false;
        }

        CampaignRoleUser::create([
            'campaign_role_id' => $campaignRole->id,
            'user_id' => $user->user_id
        ]);
        return true;
    }

    /**
     * Add a user to a role
     * @return bool
     */
    public function add(): bool
    {
        if (
            !$this->checkUserInCampaign() ||
            !$this->checkRoleInCampaign() ||
            $this->userIsInRole()
        ) {
            return false;
        }

        // If both are valid, add the user to the role
        $userRole = new CampaignRoleUser();
        $userRole->user_id = $this->user->id;
        $userRole->campaign_role_id = $this->campaignRole->id;
        $userRole->save();

        return true;
    }

    /**
     * Remove a user from a campaign role
     * @return bool
     */
    public function remove(): bool
    {
        if (
            !$this->checkUserInCampaign() ||
            !$this->checkRoleInCampaign() ||
            !$this->userIsInRole()
        ) {
            return false;
        }

        $this->userCampaignRole->delete();

        return true;
    }


    /**
     * @return bool
     * @throws TranslatableException
     */
    public function delete(): bool
    {
        // If the role isn't an admin, we can safely delete
        if (!$this->userCampaignRole->campaignRole->isAdmin()) {
            return $this->userCampaignRole->delete();
        }

        // It's the admin role. If we're deleting ourselves, make sure we have
        if ($this->userCampaignRole->user_id === $this->user->id) {
            $roleCount = $this
                ->user
                ->campaignRoles
                ->where('campaign_id', $this->userCampaignRole->campaignRole->campaign_id)
                ->count();
            if ($roleCount === 1) {
                throw (new TranslatableException(
                    'campaigns.roles.users.errors.needs_more_roles'
                ))->setOptions(['admin' => $this->userCampaignRole->campaignRole->name]);
            }
        } elseif (!$this->userCampaignRole->recentlyCreated()) {
            // If the user wasn't added to the admin role recently (ex by mistake), allow removing them
            throw (new TranslatableException(
                'campaigns.roles.users.errors.cant_kick_admins'
            ))->setOptions([
                'admin' => $this->userCampaignRole->campaignRole->name,
                'discord' => link_to(config('social.discord'), 'Discord'),
                'email' => link_to('mailto:' . config('app.email'), config('app.email'))
            ]);
        }

        return $this->userCampaignRole->delete();
    }

    /**
     * Load a user
     * @param int $userID
     * @return $this
     */
    protected function loadUser(int $userID): self
    {
        $this->user = User::find($userID);
        return $this;
    }

    /**
     * Load a campaign role
     * @param int $roleID
     * @return $this
     */
    protected function loadCampaignRole(int $roleID): self
    {
        $this->campaignRole = CampaignRole::find($roleID);
        return $this;
    }

    /**
     * Validate that the given user is in the correct campaign
     * @return bool
     */
    protected function checkUserInCampaign(): bool
    {
        return $this->campaign->users()->where('user_id', $this->user->id)->count() === 1;
    }

    /**
     * Validate that the given role is in the correct campaign
     * @return bool
     */
    protected function checkRoleInCampaign(): bool
    {
        return $this->campaignRole->campaign_id === $this->campaign->id;
    }

    /**
     * Validate that the user exists in the role
     * @return bool
     */
    protected function userIsInRole(): bool
    {
        $this
            ->userCampaignRole = CampaignRoleUser::where('user_id', $this->user->id)
            ->where('campaign_role_id', $this->campaignRole->id)
            ->first();
        return !empty($this->userCampaignRole);
    }
}
