<?php

namespace App\Services;

use App\Events\Campaigns\Dashboards\DashboardCreated;
use App\Events\Campaigns\Dashboards\DashboardUpdated;
use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardRole;
use App\Models\CampaignDashboardWidget;
use App\Models\CampaignRole;
use App\Models\Entity;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;

class DashboardService
{
    use CampaignAware;
    use RequestAware;
    use UserAware;

    // IDs of entities displayed
    protected array $displayedEntities = [];

    protected CampaignDashboard $dashboard;

    public function dashboard(CampaignDashboard $dashboard): self
    {
        $this->dashboard = $dashboard;

        return $this;
    }

    /**
     * Get the current or default dashboard for the user
     */
    public function getDashboard(?int $dashboard = null): ?CampaignDashboard
    {
        // Only available for boosted campaigns
        if (! $this->campaign->boosted()) {
            return null;
        }

        // If the campaign has no dashboards, just stop
        $available = $this->availableDashboards();
        if (empty($available)) {
            return null;
        }

        // No dashboard given, let's see what the user can access
        if (empty($dashboard)) {
            return $this->defaultDashboard($available);
        }

        // Dashboard given, make sure the user has access

        return $this->validateDashboard($available, $dashboard);
    }

    /**
     * Get the available dashboards for the user
     *
     * @return array[]|CampaignDashboard[]
     */
    public function getDashboards(): array
    {
        // Only available for boosted campaigns
        if (! $this->campaign->boosted()) {
            return [];
        }

        $available = $this->availableDashboards();
        $dashboards = [];

        if (! isset($this->user) || ! $this->campaign->userIsMember()) {
            foreach ($available['public'] as $role) {
                $dashboards[] = $role->dashboard;
            }

            return $dashboards;
        }

        // Admin?
        if ($this->user->isAdmin()) {
            foreach ($available['admin'] as $role) {
                $dashboards[] = $role->dashboard;
            }

            return $dashboards;
        }

        // Member of the campaign, check dashboards for roles of them
        $roles = UserCache::roles();
        $dashboards = [];
        foreach ($roles as $role) {
            $key = 'role_' . $role['id'];
            if (! isset($available[$key])) {
                continue;
            }
            foreach ($available[$key] as $r) {
                $dashboards[] = $r->dashboard;
            }
        }

        return $dashboards;
    }

    public function add(Entity $entity): self
    {
        $this->displayedEntities[] = $entity->id;

        return $this;
    }

    public function excluding(): array
    {
        return $this->displayedEntities;
    }

    /**
     * Create a dashboard and it's permissions
     */
    public function create(): CampaignDashboard
    {
        $this
            ->createDashboard()
            ->roles()
            ->copy();

        DashboardCreated::dispatch($this->dashboard, auth()->user());

        return $this->dashboard;
    }

    protected function createDashboard(): self
    {
        $this->dashboard = CampaignDashboard::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => $this->user->id,
            'name' => $this->request->post('name'),
        ]);

        return $this;
    }

    protected function roles(): self
    {
        // Loop through the permissions
        $roles = (array) $this->request->post('roles');
        foreach ($roles as $roleId => $setting) {
            if (empty($setting)) {
                continue;
            }

            // Validate the role
            /** @var ?CampaignRole $role */
            $role = $this->campaign->roles()->where('id', $roleId)->first();
            if (empty($role)) {
                continue;
            }

            $dashboardRole = CampaignDashboardRole::create([
                'campaign_dashboard_id' => $this->dashboard->id,
                'campaign_role_id' => $role->id,
                'is_visible' => true,
                'is_default' => $setting == 'default',
            ]);
        }

        return $this;
    }

    protected function copy(): self
    {
        if (! $this->request->filled('copy_widgets')) {
            return $this;
        }
        $sourceId = $this->request->post('source');
        /** @var ?CampaignDashboard $source */
        $source = CampaignDashboard::find($sourceId);
        if (empty($source)) {
            return $this;
        }
        /** @var CampaignDashboardWidget $widget */
        foreach ($source->widgets()->with('dashboardWidgetTags')->get() as $widget) {
            $widget->copyTo($this->dashboard);
        }

        return $this;
    }

    /**
     * @throws \Exception
     */
    public function update(): CampaignDashboard
    {
        $this->dashboard->update([
            'name' => $this->request->post('name'),
        ]);

        // Existing roles
        $roles = [];
        foreach ($this->dashboard->roles as $role) {
            $roles[$role->id] = $role;
        }

        // Loop through the permissions
        $rolesForm = (array) $this->request->post('roles');
        foreach ($rolesForm as $roleId => $setting) {
            if (empty($setting)) {
                continue;
            }

            // Validate the role
            /** @var ?CampaignRole $role */
            $role = $this->campaign->roles()->where('id', $roleId)->first();
            if (empty($role)) {
                continue;
            }

            if (isset($roles[$roleId])) {
                $role = $roles[$roleId];
                $role->update([
                    'is_default' => $setting == 'default',
                ]);
                unset($roles[$roleId]);
            } else {
                // New
                $dashboardRole = CampaignDashboardRole::create([
                    'campaign_dashboard_id' => $this->dashboard->id,
                    'campaign_role_id' => $role->id,
                    'is_visible' => true,
                    'is_default' => $setting == 'default',
                ]);
            }
        }

        // Delete any leftover roles that weren't updates
        foreach ($roles as $role) {
            $role->delete();
        }

        DashboardUpdated::dispatch($this->dashboard, auth()->user());

        return $this->dashboard;
    }

    /**
     * Get the default dashboards for the various roles
     */
    protected function availableDashboards(): array
    {
        return CampaignCache::dashboards();
    }

    /**
     * Get the default dashboard of a user
     */
    protected function defaultDashboard(array $available)
    {
        // Unlogged or not a member
        if (! isset($this->user) || ! $this->campaign->userIsMember()) {
            foreach ($available['public'] as $role) {
                if ($role->is_default) {
                    return $role->dashboard;
                }
            }

            return null;
        }

        // Admin?
        if ($this->user->isAdmin()) {
            foreach ($available['admin'] as $role) {
                if ($role->is_default) {
                    return $role->dashboard;
                }
            }

            return null;
        }

        // Member of the campaign, check dashboards for roles of them
        $roles = UserCache::roles();
        foreach ($roles as $role) {
            $key = 'role_' . $role['id'];
            if (! isset($available[$key])) {
                continue;
            }
            foreach ($available[$key] as $r) {
                if ($r->is_default) {
                    return $r->dashboard;
                }
            }
        }

        return null;
    }

    /**
     * Validate that a requested dashboard is available to the user
     *
     * @return null|CampaignDashboard
     */
    protected function validateDashboard(array $available, int $dashboard)
    {
        $filtered = false;
        if (! isset($this->user) || ! $this->campaign->userIsMember()) {
            $filtered = $available['public'];
        } elseif ($this->user) {
            $filtered = $available['admin'];
        }

        if ($filtered !== false) {
            foreach ($filtered as $role) {
                if ($role->campaign_dashboard_id == $dashboard) {
                    return $role->dashboard;
                }
            }

            return null;
        }

        $roles = UserCache::roles();
        foreach ($roles as $role) {
            $key = 'role_' . $role['id'];
            if (empty($available[$key])) {
                continue;
            }
            foreach ($available[$key] as $r) {
                if ($r->campaign_dashboard_id == $dashboard) {
                    return $r->dashboard;
                }
            }
        }

        return null;
    }
}
