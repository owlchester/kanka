<?php

namespace App\Services\Caches\Traits\Campaign;

use App\Models\CampaignRole;

trait DashboardCache
{
    /**
     * Build a list of dashboards setup for the campaign
     */
    public function dashboards(): array
    {
        $cacheKey = $this->dashboardsKey();
        if ($this->has($cacheKey)) {
            return (array) $this->get($cacheKey);
        }

        $available = [
            'admin' => [],
            'public' => [],
        ];

        /** @var CampaignRole[] $roles */
        $roles = $this->campaign->roles()->with(['dashboardRoles', 'dashboardRoles.dashboard'])->get();
        foreach ($roles as $role) {
            $dashboards = $role->dashboardRoles;
            if ($dashboards->isEmpty()) {
                continue;
            }

            $key = 'role_' . $role->id;
            if ($role->is_admin) {
                $key = 'admin';
            } elseif ($role->is_public) {
                $key = 'public';
            }
            $available[$key] = $dashboards;
        }

        $this->forever($cacheKey, $available);
        return (array) $available;
    }

    public function clearDashboards(): self
    {
        $this->forget(
            $this->dashboardsKey()
        );
        return $this;
    }

    protected function dashboardsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_dashboards';
    }
}
