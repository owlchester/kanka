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
        return $this->primary($this->campaign->id)->get('dashboards');
    }

    protected function formatDashboards(): array
    {
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

        return $available;
    }
}
