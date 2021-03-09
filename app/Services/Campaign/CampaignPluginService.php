<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Plugin;
use App\Models\PluginVersion;

class CampaignPluginService
{
    /** @var Campaign */
    protected $campaign;

    /** @var Plugin */
    protected $plugin;

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
     * @param Plugin $plugin
     * @return $this
     */
    public function plugin(Plugin $plugin): self
    {
        $this->plugin = $plugin;
        return $this;
    }

    public function enable()
    {
        $plugin = $this->campaignPlugin();
        $plugin->is_active = true;
        $plugin->save();
    }

    public function disable()
    {
        $plugin = $this->campaignPlugin();

        $plugin->is_active = false;
        $plugin->save();
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function remove()
    {
        // Find the campaign plugin
        $plugin = $this->campaignPlugin();

        if (empty($plugin)) {
            throw new \Exception(__('campaigns/plugins.errors.invalid_plugin'));
        }

        // Delete it
        $plugin->delete();

        CampaignCache::clearTheme();

        return true;
    }

    /**
     * @return CampaignPlugin|null
     */
    protected function campaignPlugin()
    {
        return CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->where('plugin_id', $this->plugin->id)
            ->first();
    }

    /**
     *
     */
    public function update()
    {
        // Get latest
        $latest = $this->plugin->versions()
            ->publishedVersions($this->plugin->created_by)
            ->orderBy('id', 'desc')
            ->first();

        /** @var CampaignPlugin $campaignPlugin */
        $campaignPlugin = CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->where('plugin_id', $this->plugin->id)
            ->first();

        $campaignPlugin->plugin_version_id = $latest->id;
        $campaignPlugin->save();

        CampaignCache::clearTheme();

    }
}
