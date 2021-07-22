<?php

namespace App\Services;

use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\User;
use Illuminate\Support\Str;

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
     * Create a new instance
     *
     * UserPermission constructor.
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
