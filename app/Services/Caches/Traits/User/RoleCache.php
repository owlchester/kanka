<?php

namespace App\Services\Caches\Traits\User;

use Illuminate\Support\Collection;

trait RoleCache
{
    /**
     * Check if a user is an admin of a campaign
     */
    public function admin(): bool
    {
        return $this->adminRole() !== null;
    }

    /**
     * Get the user's admin role in a current campaign
     */
    public function adminRole(): ?array
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
     */
    public function roles(): Collection
    {
        $roles = $this->primary($this->user->id)->get('roles');
        foreach ($roles as $campaignId => $campaignRoles) {
            if ($campaignId !== $this->campaign->id) {
                continue;
            }

            return new Collection($campaignRoles);
        }

        return new Collection;
    }
}
