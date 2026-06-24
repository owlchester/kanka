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
        $roles = $this->campaign->roles()->with('dashboardRoles')->get();
        foreach ($roles as $role) {
            if ($role->dashboardRoles->isEmpty()) {
                continue;
            }

            $key = 'role_' . $role->id;
            if ($role->is_admin) {
                $key = 'admin';
            } elseif ($role->is_public) {
                $key = 'public';
            }

            foreach ($role->dashboardRoles as $dashboardRole) {
                $available[$key][] = [
                    'campaign_dashboard_id' => $dashboardRole->campaign_dashboard_id,
                    'is_default' => (bool) $dashboardRole->is_default,
                ];
            }
        }

        return $available;
    }
}
