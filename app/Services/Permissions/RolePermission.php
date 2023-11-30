<?php

namespace App\Services\Permissions;

use App\Models\CampaignPermission;
use App\Traits\RoleAware;
use Illuminate\Database\Eloquent\Collection;

class RolePermission
{
    use RoleAware;

    protected array $permissions = [];

    protected array $rolesPermissions = [];

    /**
     * @return Collection|CampaignPermission[]|array
     */
    public function permissions()
    {
        if (isset($this->permissions[$this->role->id])) {
            return $this->permissions[$this->role->id];
        }

        return $this->permissions[$this->role->id] = $this->role->permissions;
    }

    public function rolesPermissions(array $roles): mixed
    {
        $key = implode('-', $roles);
        if (isset($this->rolesPermissions[$key])) {
            return $this->rolesPermissions[$key];
        }

        return $this->rolesPermissions[$key] = CampaignPermission::roleIds($roles)->get();
    }
}
