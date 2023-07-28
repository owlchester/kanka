<?php

namespace App\Services\Caches\Traits\Campaign;

use Illuminate\Support\Collection;

trait RoleCache
{
    public function roles(): Collection
    {
        $key = $this->rolesKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->roles;

        $this->forever($key, $data);
        return $data;
    }

    public function clearRoles(): self
    {
        $this->forget(
            $this->rolesKey()
        );
        return $this;
    }

    protected function rolesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_roles';
    }
}
