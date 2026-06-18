<?php

namespace App\Services;

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
        $available = $this->availableDashboards();
        $ids = [];

        if (! isset($this->user) || ! $this->user->can('member', $this->campaign)) {
            $ids = array_column($available['public'], 'campaign_dashboard_id');
        } elseif ($this->user->can('admin', $this->campaign)) {
            $ids = array_column($available['admin'], 'campaign_dashboard_id');
        } else {
            $roles = UserCache::roles();
            foreach ($roles as $role) {
                $key = 'role_' . $role['id'];
                if (isset($available[$key])) {
                    $ids = array_merge($ids, array_column($available[$key], 'campaign_dashboard_id'));
                }
            }
        }

        return CampaignDashboard::whereIn('id', $ids)->get()->all();
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

        return $this->dashboard;
    }

    protected function defaultIdFrom(array $entries): ?int
    {
        foreach ($entries as $entry) {
            if ($entry['is_default']) {
                return $entry['campaign_dashboard_id'];
            }
        }

        return null;
    }

    protected function findIdIn(array $entries, int $dashboardId): ?int
    {
        foreach ($entries as $entry) {
            if ($entry['campaign_dashboard_id'] === $dashboardId) {
                return $dashboardId;
            }
        }

        return null;
    }

    /**
     * Get the default dashboards for the various roles
     */
    protected function availableDashboards(): array
    {
        return CampaignCache::campaign($this->campaign)->dashboards();
    }

    /**
     * Get the default dashboard of a user
     */
    protected function defaultDashboard(array $available)
    {
        $id = null;

        // Unlogged or not a member
        if (! isset($this->user) || ! $this->user->can('member', $this->campaign)) {
            $id = $this->defaultIdFrom($available['public']);
        } elseif ($this->user->can('admin', $this->campaign)) {
            $id = $this->defaultIdFrom($available['admin']);
        } else {
            $roles = UserCache::roles();
            foreach ($roles as $role) {
                $key = 'role_' . $role['id'];
                if (isset($available[$key])) {
                    $id = $this->defaultIdFrom($available[$key]);
                    if ($id !== null) {
                        break;
                    }
                }
            }
        }

        return $id ? CampaignDashboard::find($id) : null;
    }

    /**
     * Validate that a requested dashboard is available to the user
     *
     * @return null|CampaignDashboard
     */
    protected function validateDashboard(array $available, int $dashboard)
    {
        $id = null;

        if (! isset($this->user) || ! $this->user->can('member', $this->campaign)) {
            $id = $this->findIdIn($available['public'], $dashboard);
        } elseif ($this->user) {
            $id = $this->findIdIn($available['admin'], $dashboard);
        }

        if ($id === null) {
            $roles = UserCache::roles();
            foreach ($roles as $role) {
                $key = 'role_' . $role['id'];
                if (! empty($available[$key])) {
                    $id = $this->findIdIn($available[$key], $dashboard);
                    if ($id !== null) {
                        break;
                    }
                }
            }
        }

        return $id ? CampaignDashboard::find($id) : null;
    }
}
