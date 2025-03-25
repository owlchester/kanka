<?php

namespace App\Services\Caches\Traits\Campaign;

trait RoleCache
{
    // Used to cache the whole roles as objects in the cache, just for the public role permission.
    // There are better ways to handle this!

    public function publicPermissions(): array
    {
        return $this->primary($this->campaign->id)->get('public-permissions');
    }

    /**
     * Build a list of dashboards setup for the campaign
     *
     * @return array[]
     */
    public function adminRole(): array
    {
        return $this->primary($this->campaign->id)->get('admin-role');
    }

    protected function formatAdminRole(): array
    {
        $role = $this->campaign->roles->where('is_admin', 1)->first();

        return [
            'id' => $role->id,
            'name' => $role->name,
        ];
    }
}
