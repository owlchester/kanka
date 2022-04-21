<?php

namespace App\Services\Caches;

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\CampaignRole;
use App\Models\CampaignSetting;
use App\Models\Plugin;
use App\Models\PluginVersion;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

/**
 * Class CampaignCacheService
 * @package App\Services\Caches
 */
class CampaignCacheService extends BaseCache
{
    /**
     * Members of a campaign
     * @return Collection
     */
    public function members(): Collection
    {
        $key = $this->membersKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->members;

        $this->forever($key, $data);
        return $data;
    }

    /**
     * Clear the members cache
     * @return $this
     */
    public function clearMembers(): self
    {
        $this->forget(
            $this->membersKey()
        );
        return $this;
    }

    /**
     * @return Collection
     */
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

    /**
     * Clear the campaign roles cache
     * @return $this
     */
    public function clearRoles(): self
    {
        $this->forget(
            $this->rolesKey()
        );
        return $this;
    }

    /**
     * Count the number of entities in a campaign. Cache if for 6 hours
     * @param string|null $type
     * @return int
     */
    public function entityCount(string $type = null): int
    {
        $key = 'campaign_' . $this->campaign->id . '_entity_count' . (!empty($type) ? "_$type" : null);
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->entities()->count();

        $this->put($key, $data, 6 * 3600);
        return $data;
    }

    /**
     * Count the number of followers of a campaign. Cache if for 1 hours
     * @return int
     */
    public function followerCount(): int
    {
        $key = 'campaign_' . $this->campaign->id . '_follower_count';
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->followers()->count();
        $this->forever($key, $data);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearFollowerCount(): self
    {
        $key = 'campaign_' . $this->campaign->id . '_follower_count';
        $this->forget(
            $key
        );
        return $this;
    }


    /**
     * Count the number of followers of a campaign. Cache if for 1 hours
     * @return int
     */
    public function settings(): CampaignSetting
    {
        $key = $this->settingsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->setting;
        $this->forever($key, $data);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearSettings(): self
    {
        $this->forget(
            $this->settingsKey()
        );
        return $this;
    }

    /**
     * Default Entity Images for a campaign
     * @return array
     */
    public function defaultImages(): array
    {
        $key = $this->defaultImagesKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $defaults = $this->campaign->defaultImages();
        $data = [];
        foreach ($defaults as $default) {
            $data[Str::singular($default['type'])] = $default;
        }
        $this->forever($key, $data);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearDefaultImages(): self
    {
        $this->forget(
            $this->defaultImagesKey()
        );
        return $this;
    }

    /**
     * Get the public campaign systems and cache them for a day
     * @param string|null $type
     * @return int
     */
    public function systems(): array
    {
        $key = 'campaign_public_systems';
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = Campaign::selectRaw('system, count(*) as cpt')
            ->public()
            ->whereNotNull('system')
            ->groupBy('system')
            ->orderBy('system')
            ->get();

        $data = $data->where('cpt', '>=', 5)->pluck('system', 'system')->toArray();

        $this->put($key, $data, 24 * 3600);
        return $data;
    }

    /**
     * @return $this
     */
    public function clearTheme(): self
    {
        $this->forget(
            $this->themeKey()
        );
        return $this;
    }

    /**
     * List of themes the campaign has activated
     * @return PluginVersion|mixed|null
     */
    public function themes(): string
    {
        if (!config('marketplace.enabled')) {
            return false;
        }

        $key = $this->themeKey();
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        /** @var CampaignPlugin $plugin */
        $theme = '';
        $plugins = CampaignPlugin::leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('campaign_id', $this->campaign->id)
            ->where('p.type_id', 1)
            ->where('is_active', true)
            ->with('version')
            ->has('plugin')
            ->get();
        foreach ($plugins as $plugin) {
            $theme .= "/** plugin: " . e($plugin->name) . " #" . e($plugin->version->version) . " **/\n";
            $theme .= $plugin->version->content."\n\n";
        }

        $this->forever($key, $theme);
        return (string) $theme;
    }

    /**
     * Build campaign styles
     * @return string
     */
    public function styles(): string
    {
        $key = $this->stylesKey();
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        $css = "/**\n * Campaign Styles for #" . $this->campaign->id . "\n */\n\n";
        foreach ($this->campaign->styles()->enabled()->defaultOrder()->get() as $style) {
            $css .= "/** Style " . $style->name . "#" . $style->id . " */\n" . $style->content . "\n";
        }

        $this->forever($key, $css);
        return (string) $css;
    }

    public function stylesTimestamp(): int
    {
        $key = $this->stylesTsKey();
        if ($this->has($key)) {
            return (int) $this->get($key);
        }

        $ts = time();
        $this->forever($key, $ts);
        return (int) $ts;
    }

    /**
     * @return $this
     */
    public function clearStyles(): self
    {
        $this->forget(
            $this->stylesKey()
        );
        $this->forget(
            $this->stylesTsKey()
        );
        return $this;
    }

    /**
     * Build a list of dashboards setup for the campaign
     * @return array[]
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

    /**
     * @return $this
     */
    public function clearDashboards(): self
    {
        $this->forget(
            $this->dashboardsKey()
        );
        return $this;
    }

    /**
     * Build a list of dashboards setup for the campaign
     * @return array[]
     */
    public function adminRole(): array
    {
        $cacheKey = $this->adminRoleKey();
        if ($this->has($cacheKey)) {
            return (array) $this->get($cacheKey);
        }

        $role = $this->campaign->roles->where('is_admin', 1)->first();
        $data = [
            'id' => $role->id,
            'name' => $role->name
        ];

        $this->forever($cacheKey, $data);
        return (array) $data;
    }

    /**
     * @return $this
     */
    public function clearAdminRole(): self
    {
        $this->forget(
            $this->adminRoleKey()
        );
        return $this;
    }

    /**
     * Campaign members cache key
     * @return string
     */
    protected function membersKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_members';
    }

    /**
     * Campaign roles cache key
     * @return string
     */
    protected function rolesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_roles';
    }

    /**
     * Campaign settings cache key
     * @return string
     */
    protected function settingsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_settings';
    }

    /**
     * Campaign default images cache key
     * @return string
     */
    protected function defaultImagesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_default_images';
    }

    /**
     * Campaign plugin theme cache key
     * @return string
     */
    protected function themeKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_theme';
    }

    /**
     * Campaign styles cache key
     * @return string
     */
    protected function stylesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_styles';
    }

    /**
     * Campaign styles timestamp cache key
     * @return string
     */
    protected function stylesTsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_styles_ts';
    }

    /**
     * Campaign dashboards cache key
     * @return string
     */
    protected function dashboardsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_dashboards';
    }

    /**
     * Campaign dashboards cache key
     * @return string
     */
    protected function adminRoleKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_admin_role';
    }
}
