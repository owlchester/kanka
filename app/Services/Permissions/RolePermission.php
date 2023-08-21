<?php

namespace App\Services\Permissions;

use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use Illuminate\Database\Eloquent\Collection;

class RolePermission
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    protected CampaignRole $role;

    /** @var array */
    protected array $permissions = [];
    protected array $rolesPermissions = [];

    /**
     *
     */
    public function __construct()
    {
        $this->app = app();
    }

    /**
     * @param CampaignRole $role
     * @return $this
     */
    public function role(CampaignRole $role): self
    {
        $this->role = $role;
        return $this;
    }

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

    public function rolesPermissions(array $roles)
    {
        $key = implode('-', $roles);
        if (isset($this->rolesPermissions[$key])) {
            return $this->rolesPermissions[$key];
        }

        return $this->rolesPermissions[$key] = CampaignPermission::roleIds($roles)->get();
    }
}
