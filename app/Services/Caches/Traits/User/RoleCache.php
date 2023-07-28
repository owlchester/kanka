<?php

namespace App\Services\Caches\Traits\User;

use Illuminate\Support\Collection;

trait RoleCache
{
    /**
     * Check if a user is an admin of a campaign
     * @return bool
     */
    public function admin(): bool
    {
        return $this->adminRole()
            ->count() === 1;
    }

    /**
     * Get the user's admin role in a current campaign
     * @return Collection
     */
    public function adminRole(): Collection
    {
        return $this->roles()
            ->where('campaign_id', $this->campaign->id)
            ->where('is_admin', true);
    }



    /**
     * Get the user roles
     * @return Collection
     */
    public function roles(): Collection
    {
        $key = $this->rolesKey();
        if ($this->has($key)) {
            $roles = $this->get($key);
            if ($roles !== null) {
                return $roles;
            }
        }

        $data = $this->user->campaignRoles;
        $this->forever($key, $data);

        return $data;
    }

    /**
     * Clear user roles cache
     * @return $this
     */
    public function clearRoles(): self
    {
        $key = $this->rolesKey();
        $this->forget($key);
        return $this;
    }

    protected function rolesKey(): string
    {
        return 'user_' . $this->user->id . '_roles';
    }
}
