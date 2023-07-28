<?php

namespace App\Services\Caches;

use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Services\Caches\Traits\Campaign\DashboardCache;
use App\Services\Caches\Traits\Campaign\MemberCache;
use App\Services\Caches\Traits\Campaign\RoleCache;
use App\Services\Caches\Traits\Campaign\SettingCache;
use App\Services\Caches\Traits\Campaign\StyleCache;
use App\Services\Caches\Traits\Campaign\ThemeCache;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class CampaignCacheService
 * @package App\Services\Caches
 */
class CampaignCacheService extends BaseCache
{
    use MemberCache;
    use SettingCache;
    use StyleCache;
    use ThemeCache;
    use DashboardCache;
    use RoleCache;

    /**
     * Count the number of entities in a campaign, skipping the permission engine.
     * @return int
     */
    public function entityCount(): int
    {
        $key = 'campaign_' . $this->campaign->id . '_entity_count';
        if ($this->has($key)) {
            return $this->get($key);
        }

        // @phpstan-ignore-next-line
        $data = $this->campaign->entities()->withInvisible()->count();

        $this->put($key, $data, 6 * 3600);
        return $data;
    }

    /**
     * @return array
     */
    public function admins(): array
    {
        $key = $this->adminsKey();
        if ($this->has($key)) {
            return $this->get($key);
        }

        $data = $this->campaign->roles()->admin()->first()->users->pluck('id')->toArray();
        $this->forever($key, $data);
        return $data;
    }

    /**
     * Forget about a campaign's admins
     * @return $this
     */
    public function clearAdmins(): self
    {
        $this->forget($this->adminsKey());
        return $this;
    }

    /**
     * Campaign admin cache key
     * @return string
     */
    protected function adminsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_admins';
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
     * @return array
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
     * List of theme plugins the campaign has activated
     * @return string|bool
     */
    public function themes(): string|bool
    {
        if (!config('marketplace.enabled')) {
            return false;
        }

        $key = $this->themeKey();
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        $theme = '';
        // @phpstan-ignore-next-line
        $plugins = CampaignPlugin::leftJoin('plugins as p', 'p.id', 'plugin_id')
            ->where('campaign_id', $this->campaign->id)
            ->where('p.type_id', 1)
            ->where('is_active', true)
            ->with('version')
            ->has('plugin')
            ->has('plugin.user')
            ->get();
        /** @var CampaignPlugin $plugin */
        foreach ($plugins as $plugin) {
            if ($plugin->version->fonts) {
                $theme .= "/** plugin: " . e($plugin->name) . " #" . e($plugin->version->version) . " fonts **/\n";
                $theme .= $plugin->version->fonts . "\n\n";
            }
        }
        foreach ($plugins as $plugin) {
            $theme .= "/** plugin: " . e($plugin->name) . " #" . e($plugin->version->version) . " code **/\n";
            $theme .= $plugin->version->content . "\n\n";
        }

        $this->forever($key, $theme);
        return (string) $theme;
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
     * Campaign default images cache key
     * @return string
     */
    protected function defaultImagesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_default_images';
    }

    /**
     * @return string
     */
    protected function adminRoleKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_admin_role';
    }
}
