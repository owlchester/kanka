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
        return $this->adminRole() !== null;
    }

    /**
     * Get the user's admin role in a current campaign
     * @return array|null
     */
    public function adminRole(): array|null
    {
        foreach ($this->roles() as $role) {
            if ($role['is_admin']) {
                return $role;
            }
        }
        return null;
    }

    /**
     * Get the user roles
     * @return Collection
     */
    public function roles(): Collection
    {
        $roles = $this->primary()->get('roles');
        foreach ($roles as $campaignId => $campaignRoles) {
            if ($campaignId !== $this->campaign->id) {
                continue;
            }
            return new Collection($campaignRoles);
        }
        return new Collection();
    }
}
