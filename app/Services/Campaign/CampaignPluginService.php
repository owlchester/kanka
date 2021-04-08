<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\Plugin;
use App\Models\PluginVersion;
use Illuminate\Support\Str;

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

    /**
     * Import a content pack's entities into the campaign.
     */
    public function import()
    {
        if (!$this->plugin->isContentPack()) {
            throw new \Exception('not_content_pack');
        }

        // Prepare the uuids for already imported lookups
        $campaignPlugin = $this->campaignPlugin();
        $version = $campaignPlugin->version;
        $entities = $version->entities()->with('type')->get();
        $uuids = $entities->pluck('uuid');

        $importedEntities = Entity::whereIn('marketplace_uuid', $uuids)->get();

        $miscMapping = [];
        $entityMapping = [];
        $models = [];

        foreach ($entities as $pluginEntity) {
            // Updating?
            $model = $importedEntities->where('marketplace_uuid', $pluginEntity->uuid)->first();
            if ($model) {
                $entityMapping[$pluginEntity->id] = $model->id;
                $miscMapping[$pluginEntity->id] = $model->entity_id;
                dump('existing ' . $pluginEntity->uuid);
                $model = $model->child;
            } else {
                $className = '\App\Models\\' . Str::studly($pluginEntity->type->code);
                dump('new ' . $className);

                /** @var MiscModel $model */
                $model = new $className();
                $model->name = $pluginEntity->name;
                $model->entry = $pluginEntity->entry;
                $model->save();

                $entity = $model->entity;
                $entity->marketplace_uuid = $pluginEntity->uuid;
                $entity->save();

                $miscMapping[$pluginEntity->id] = $model->id;
                $entityMapping[$pluginEntity->id] = $model->entity->id;
            }
            $models[$pluginEntity->id] = $model;
        }

        dump('Misc Mapping');
        dump($miscMapping);
        dump('Entity Mapping');
        dump($entityMapping);
        // Now what we have the base models and mappings, let's go again and post those fields
        foreach ($entities as $pluginEntity) {
            $model = $models[$pluginEntity->id];
            foreach ($pluginEntity->fields as $field => $value) {
                // parent mapping
                if ($field == 'location_id' && $pluginEntity->type_id == config('entities.ids.location')) {
                    $field = 'parent_location_id';
                } elseif ($field == 'gender') {
                    $field = 'sex';
                }
                // Foreign key
                if (Str::endsWith($field, '_id')) {
                    if (empty($value)) {
                        $model->$field = null;
                    } else {
                        dd('looking for ' . $field . ' with value ' . $value);
                        $model->$field = $miscMapping[$value];
                    }
                } else {
                    $model->$field = $value;
                }
            }
            $model->save();
        }

        dd('yo');
        return 0;
    }
}
