<?php

namespace App\Services\Permissions;

use App\Models\CampaignRole;

class RolePermission
{
    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var CampaignRole
     */
    protected $role;

    /** @var array */
    protected $permissions = [];

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
     * @return array
     */
    public function permissions()
    {
        if (isset($this->permissions[$this->role->id])) {
            return $this->permissions[$this->role->id];
        }

        return $this->permissions[$this->role->id] = $this->role->permissions;
    }
}
