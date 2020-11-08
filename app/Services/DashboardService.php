<?php


namespace App\Services;


use App\Facades\CampaignCache;
use App\Facades\UserCache;
use App\Http\Requests\StoreCampaignDashboard;
use App\Models\Campaign;
use App\Models\CampaignDashboard;
use App\Models\CampaignDashboardRole;
use App\Models\CampaignRole;
use App\Models\Entity;

class DashboardService
{
    /** @var array IDs of entities displayed */
    protected $displayedEntities = [];

    /** @var Campaign */
    protected $campaign;

    /** @var CampaignDashboard */
    protected $dashboard;

    /**
     * @param Campaign $campaign
     * @return $this
     */
    public function campaign(Campaign $campaign): self
    {
        $this->campaign = $campaign;
        return $this;
    }

    /**
     * @param CampaignDashboard $dashboard
     * @return $this
     */
    public function dashboard(CampaignDashboard $dashboard): self
    {
        $this->dashboard = $dashboard;
        return $this;
    }

    /**
     * Get the current or default dashboard for the user
     * @param int|null $dashboard
     * @return null
     */
    public function getDashboard(int $dashboard = null)
    {
        // Only available for boosted campaigns
        if (!$this->campaign->boosted()) {
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
     * @return array[]
     */
    public function getDashboards()
    {
        // Only available for boosted campaigns
        if (!$this->campaign->boosted()) {
            return [];
        }

        $available = $this->availableDashboards();
        $dashboards = [];

        if (!auth()->check() || !$this->campaign->userIsMember()) {
            foreach ($available['public'] as $role) {
                $dashboards[] = $role->dashboard;
            }
            return $dashboards;
        }

        // Admin?
        if (auth()->user()->isAdmin()) {
            foreach ($available['admin'] as $role) {
                $dashboards[] = $role->dashboard;
            }
            return $dashboards;
        }

        // Member of the campaign, check dashboards for roles of them
        $roles = UserCache::roles();
        $dashboards = [];
        foreach ($roles as $role) {
            $key = 'role_' . $role->id;
            foreach ($available[$key] as $role) {
                $dashboards[] = $role->dashboard;
            }
        }

        return $dashboards;
    }

    /**
     * @param Entity $entity
     * @return $this
     */
    public function add(Entity $entity): self
    {
        $this->displayedEntities[] = $entity->id;
        return $this;
    }

    /**
     * @return array
     */
    public function excluding(): array
    {
        return $this->displayedEntities;
    }

    /**
     * Create a dashboard and it's permissions
     * @param StoreCampaignDashboard $request
     * @return CampaignDashboard
     */
    public function create(StoreCampaignDashboard $request): CampaignDashboard
    {
        $dashboard = CampaignDashboard::create([
            'campaign_id' => $this->campaign->id,
            'created_by' => auth()->user()->id,
            'name' => $request->post('name')
        ]);

        // Loop through the permissions
        $roles = $request->post('roles');
        foreach ($roles as $roleId => $setting) {
            if (empty($setting)) {
                continue;
            }

            // Validate the role
            /** @var CampaignRole $role */
            $role = $this->campaign->roles()->where('id', $roleId)->first();
            if (empty($role)) {
                continue;
            }

            $dashboardRole = CampaignDashboardRole::create([
                'campaign_dashboard_id' => $dashboard->id,
                'campaign_role_id' => $role->id,
                'is_visible' => true,
                'is_default' => $setting == 'default'
            ]);
        }

        CampaignCache::clearDashboards();

        return $dashboard;
    }

    /**
     * @param StoreCampaignDashboard $request
     * @return CampaignDashboard
     * @throws \Exception
     */
    public function update(StoreCampaignDashboard $request): CampaignDashboard
    {
        $this->dashboard->update([
            'name' => $request->post('name')
        ]);

        // Existing roles
        $roles = [];
        foreach ($this->dashboard->roles as $role) {
            $roles[$role->id] = $role;
        }

        // Loop through the permissions
        $rolesForm = $request->post('roles');
        foreach ($rolesForm as $roleId => $setting) {
            if (empty($setting)) {
                continue;
            }

            // Validate the role
            /** @var CampaignRole $role */
            $role = $this->campaign->roles()->where('id', $roleId)->first();
            if (empty($role)) {
                continue;
            }

            if (isset($roles[$roleId])) {
                $role = $roles[$roleId];
                $role->update([
                    'is_default' => $setting == 'default'
                ]);
                unset($roles[$roleId]);
            } else {
                // New
                $dashboardRole = CampaignDashboardRole::create([
                    'campaign_dashboard_id' => $this->dashboard->id,
                    'campaign_role_id' => $role->id,
                    'is_visible' => true,
                    'is_default' => $setting == 'default'
                ]);
            }
        }

        // Delete any leftover roles that weren't updates
        foreach ($roles as $role) {
            $role->delete();
        }

        CampaignCache::clearDashboards();

        return $this->dashboard;
    }

    /**
     * Get the default dashboards for the various roles
     * @return array
     */
    protected function availableDashboards(): array
    {
        return CampaignCache::dashboards();
    }

    /**
     * Get the default dashboard of a user
     * @param array $available
     * @return null
     */
    protected function defaultDashboard(array $available)
    {
        // Unlogged or not a member
        if (!auth()->check() || !$this->campaign->userIsMember()) {
            foreach ($available['public'] as $role) {
                if ($role->is_default) {
                    return $role->dashboard;
                }
            }
            return null;
        }

        // Admin?
        if (auth()->user()->isAdmin()) {
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
            $key = 'role_' . $role->id;
            foreach ($available[$key] as $role) {
                if ($role->is_default) {
                    return $role->dashboard;
                }
            }
        }

        return null;
    }

    /**
     * Validate that a requested dashboard is available to the user
     * @param array $available
     * @param int $dashboard
     * @return null
     */
    protected function validateDashboard(array $available, int $dashboard)
    {
        $filtered = false;
        if (!auth()->check() || !$this->campaign->userIsMember()) {
            $filtered = $available['public'];
        } elseif (auth()->user()->isAdmin()) {
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
            $key = 'role_' . $role->id;
            if (empty($available[$key])) {
                continue;
            }
            foreach ($available[$key] as $role) {
                if ($role->campaign_dashboard_id == $dashboard) {
                    return $role->dashboard;
                }
            }
        }

        return null;
    }
}
