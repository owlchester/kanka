<?php

namespace App\Services\Campaign;

use App\Models\CampaignPlugin;
use App\Models\Plugin;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;

class PluginService
{
    use CampaignAware;
    use UserAware;

    protected Plugin $plugin;

    public function plugin(Plugin $plugin): self
    {
        $this->plugin = $plugin;

        return $this;
    }

    public function enable(): bool
    {
        $plugin = $this->campaignPlugin();
        if ($plugin->canEnable()) {
            $plugin->is_active = true;
            $plugin->save();

            return true;
        }

        return false;
    }

    public function disable(): bool
    {
        $plugin = $this->campaignPlugin();

        if ($plugin->canDisable()) {
            $plugin->is_active = false;
            $plugin->save();

            return true;
        }

        return false;
    }

    public function remove(): bool
    {
        // Find the campaign plugin
        $plugin = $this->campaignPlugin();

        if (empty($plugin)) {
            throw new Exception(__('campaigns/plugins.errors.invalid_plugin'));
        }

        $plugin->delete();

        return true;
    }

    protected function campaignPlugin(): ?CampaignPlugin
    {
        return CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->where('plugin_id', $this->plugin->id)
            ->first();
    }

    public function update(): bool
    {
        // Get latest
        $latest = $this->plugin->versions()
            ->publishedVersions($this->plugin->created_by === $this->user->id)
            ->orderBy('id', 'desc')
            ->first();
        // The user could be submitting a plugin to update that was removed in another window
        if (empty($latest)) {
            return false;
        }

        /** @var CampaignPlugin $campaignPlugin */
        $campaignPlugin = CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->where('plugin_id', $this->plugin->id)
            ->first();

        if ($campaignPlugin->plugin_version_id === $latest->id) {
            return false;
        }

        $campaignPlugin->plugin_version_id = $latest->id;
        $campaignPlugin->save();

        return true;
    }
}
