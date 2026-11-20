<?php

namespace App\Services\Permissions;

use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use Illuminate\Database\Eloquent\Collection;

class RolePermission
{
    /** @var array<int, Collection<int, CampaignPermission>> */
    protected array $permissions = [];

    /** @var array<string, Collection<int, CampaignPermission>> */
    protected array $rolesPermissions = [];

    /**
     * @return Collection<int, CampaignPermission>
     */
    public function permissions(CampaignRole $role): Collection
    {
        return $this->permissions[$role->id] ??= $role->permissions;
    }

    /**
     * @param  array<int, int>  $roles
     * @return Collection<int, CampaignPermission>
     */
    public function rolesPermissions(array $roles): Collection
    {
        $key = implode('-', $roles);

        return $this->rolesPermissions[$key] ??= CampaignPermission::roleIds($roles)->get();
    }
}
