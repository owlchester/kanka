<?php

namespace App\Services\Campaign;

use App\Exceptions\TranslatableException;
use App\Facades\CampaignCache;
use App\Http\Requests\API\UpdateUserRole;
use App\Models\CampaignRole;
use App\Models\CampaignRoleUser;
use App\Models\CampaignUser;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use App\Models\User;

class MemberService
{
    use CampaignAware;
    use UserAware;

    protected CampaignRole $campaignRole;

    /**  */
    protected ?CampaignRoleUser $userCampaignRole;

    public function element(CampaignRoleUser $campaignRoleUser): self
    {
        $this->userCampaignRole = $campaignRoleUser;
        return $this;
    }

    /**
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
     */
    public function update(CampaignUser $user, array $roles): bool
    {
        $currentRoles = $user->roles->pluck('id')->toArray();
        $roleUsers = CampaignRoleUser::where('user_id', $user->user_id)
            ->whereIn('campaign_role_id', $currentRoles)
            ->whereNotIn('campaign_role_id', $roles)
            ->with('campaignRole')
            ->get();

        $deletedRoles = [];
        /** @var ?CampaignRoleUser $role */
        foreach ($roleUsers as $role) {
            // Admin role being switched? Forget the cache
            if ($role->campaignRole->isAdmin()) {
                CampaignCache::campaign($this->campaign)->clear();
            }
            // Deleting an existing role
            if ($role->campaignRole->isAdmin() && !$role->recentlyCreated()) {
                throw (new TranslatableException(
                    'campaigns.roles.users.errors.cant_kick_admins'
                ))->setOptions([
                    'admin' => $role->campaignRole->name,
                    'discord' => '<a href="' . config('social.discord') . '>Discord</a>',
                    'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>',
                ]);
            }
            $deletedRoles[] = $role->id;
            $role->delete();
        }
        $rolesToCreate = array_diff_key($roles, $currentRoles);
        foreach ($rolesToCreate as $role) {
            CampaignRoleUser::create([
                'campaign_role_id' => $role,
                'user_id' => $user->user_id
            ]);
        }
        return true;
    }

    /**
     * Add a user to a role
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
     * @throws TranslatableException
     */
    public function delete(): bool
    {
        // If the role isn't an admin, we can safely delete
        if (!$this->userCampaignRole->campaignRole->isAdmin()) {
            return $this->userCampaignRole->delete();
        }

        // It's the admin role. Only allow if campaign author or self
        $userIsCreator = $this->userCampaignRole->campaignRole->campaign->created_by === $this->user->id;
        if ($this->userCampaignRole->user_id === $this->user->id || $userIsCreator) {
            $roleCount = $this
                ->user
                ->campaignRoles
                ->where('campaign_id', $this->userCampaignRole->campaignRole->campaign_id)
                ->count();
            // Stop a user from having 0 roles
            if ($this->userCampaignRole->user_id === $this->user->id && $roleCount === 1) {
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
                'discord' => '<a href="' . config('social.discord') . '>Discord</a>',
                'email' => '<a href="mailto:' . config('app.email') . '">' . config('app.email') . '</a>',
            ]);
        }

        return $this->userCampaignRole->delete();
    }

    /**
     * Load a user
     * @return $this
     */
    protected function loadUser(int $userID): self
    {
        $this->user = User::find($userID);
        return $this;
    }

    /**
     * Load a campaign role
     * @return $this
     */
    protected function loadCampaignRole(int $roleID): self
    {
        $this->campaignRole = CampaignRole::find($roleID);
        return $this;
    }

    /**
     * Validate that the given user is in the correct campaign
     */
    protected function checkUserInCampaign(): bool
    {
        return $this->campaign->users()->where('user_id', $this->user->id)->count() === 1;
    }

    /**
     * Validate that the given role is in the correct campaign
     */
    protected function checkRoleInCampaign(): bool
    {
        return $this->campaignRole->campaign_id === $this->campaign->id;
    }

    /**
     * Validate that the user exists in the role
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
