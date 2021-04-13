<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Models\Plugin;
use App\Models\PluginVersion;
use App\Models\PluginVersionEntity;
use App\Models\Relation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class CampaignPluginService
{
    /** @var Campaign */
    protected $campaign;

    /** @var Plugin */
    protected $plugin;

    /** @var array */
    protected $entityIds = [];

    /** @var array  */
    protected $miscIds = [];

    /** @var array  */
    protected $entityTypes = [];

    /** @var array */
    protected $models = [];

    /** @var array */
    protected $loadedRelations = [];

    /** @var null|Collection */
    protected $importedEntities = null;

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
            throw new Exception('not_content_pack');
        }

        // Prepare the uuids for already imported lookups
        $campaignPlugin = $this->campaignPlugin();
        $version = $campaignPlugin->version;
        $entities = $version->entities()->with('type')->get();
        $uuids = $entities->pluck('uuid');

        $this->importedEntities = Entity::whereIn('marketplace_uuid', $uuids)->get();
        $count = 0;

        /**
         * First we create the base model for all entities, or load existing ones from the db
         */
        foreach ($entities as $pluginEntity) {
            $this->importModel($pluginEntity);
        }

        /*dump('Misc Mapping');
        dump($this->miscIds);
        dump('Entity Mapping');
        dump($this->entityIds);*/
        // Now what we have the base models and mappings, let's go again and post those fields
        foreach ($entities as $pluginEntity) {
            $this->importFields($pluginEntity);
            $count++;
        }

        return $count;
    }

    /**
     * @param PluginVersionEntity $pluginEntity
     */
    protected function importModel(PluginVersionEntity $pluginEntity)
    {
        // Updating?
        /** @var Entity $model */
        $model = $this->importedEntities->where('marketplace_uuid', $pluginEntity->uuid)->first();
        if ($model) {
            $this->entityIds[$pluginEntity->id] = $model->id;
            $this->miscIds[$pluginEntity->id] = $model->entity_id;
            $this->entityTypes[$pluginEntity->id] = $model->type;
            //dump('existing ' . $pluginEntity->uuid);
            $model = $model->child;
        } else {
            $className = '\App\Models\\' . Str::studly($pluginEntity->type->code);
            //dump('new ' . $className);

            /** @var MiscModel $model */
            $model = new $className();
            $model->name = $pluginEntity->name;
            //$model->entry = $this->$pluginEntity->entry;
            $model->save();

            $entity = $model->entity;
            $entity->marketplace_uuid = $pluginEntity->uuid;
            $entity->save();

            $this->miscIds[$pluginEntity->id] = $model->id;
            $this->entityTypes[$pluginEntity->id] = $model->getEntityType();
            $this->entityIds[$pluginEntity->id] = $model->entity->id;
        }
        $this->models[$pluginEntity->id] = $model;
    }

    /**
     * @param PluginVersionEntity $pluginEntity
     */
    protected function importFields(PluginVersionEntity $pluginEntity)
    {
        //dump('Parsing entity ' . $pluginEntity->name . ' #' . $pluginEntity->id . '');
        $model = $this->models[$pluginEntity->id];
        $entityId = $this->getEntityId($pluginEntity->id);
        $blocks = ['personality', 'appearance'];
        //dump("entityId: $entityId");
        foreach ($pluginEntity->fields as $field => $value) {
            //dump("field $field => $value");
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
                    $model->$field = $this->miscIds[$value];
                }
            } elseif (in_array($field, $blocks)) {
                $this->importBlock($field, $value, $model);
            } else {
                $model->$field = $value;
            }
        }

        $model = $this->importImage($model, $pluginEntity);

        // Mentions
        $model->entry = preg_replace_callback('`\[entity:(.*?)\]`i', function ($matches) {
            $id = (int) $matches[1];
            if (empty($id) || !isset($this->entityIds[$id])) {
                return 'wat';
            }

            return '[' . $this->entityTypes[$id] . ':' . $this->entityIds[$id] . ']';
        }, $pluginEntity->entry);

        $model->save();

        // Relations
        if (!empty($pluginEntity->related)) {
            foreach ($pluginEntity->related as $type => $fields) {
                $this->loadRelations($model);
                foreach ($fields as $uuid => $data) {
                    if ($type == 'relation') {
                        $this->saveRelation($data, $uuid, $entityId);
                    } elseif ($type == 'member') {
                        $this->saveOrganisationMember($data, $uuid, $model->id, $pluginEntity);
                    } else {
                        Log::info('Unknown relation type \'' . $type . '\' for marketplace entity #' . $pluginEntity->id);
                    }
                }
            }
        }
    }

    /**
     * Create or update a relation
     * @param array $data
     * @param string $uuid
     * @param int $ownerId
     */
    protected function saveRelation(array $data, string $uuid, int $ownerId)
    {
        //dump("New relation for $ownerId");
        //dump($data);

        $targetId = $this->getEntityId($data['target']);
        if (empty($targetId) || empty($data['relation'])) {
            return;
        }

        try {
            $relation = $this->loadedRelations[$uuid] ?? null;
            if (empty($relation)) {
                $relation = new Relation();
                $relation->owner_id = $ownerId;
                $relation->marketplace_uuid = $uuid;
            }

            $relation->target_id = $targetId;
            $relation->colour = Arr::get($data, 'colour', null);
            $relation->attitude = Arr::get($data, 'attitude', null);
            $relation->relation = Arr::get($data, 'relation', null);
            $relation->save();
        } catch (Exception $e) {
            Log::error('Invalid relation for owner ' . $ownerId . ' and uuid ' . $uuid . ': ' . $e->getMessage());
        }
    }

    /**
     * @param array $data
     * @param string $uuid
     * @param int $characterId
     * @param PluginVersionEntity $pluginEntity
     */
    protected function saveOrganisationMember(array $data, string $uuid, int $characterId, PluginVersionEntity $pluginEntity)
    {
        // Check the target org
        //dump('adding org member for ' . $characterId);
        $organisation = $this->miscIds[$data['target']];
        if (empty($organisation)) {
            return;
        }

        // Look if already exists
        try {
            $member = OrganisationMember::where('character_id', $characterId)
                ->where('organisation_id', $organisation)
                ->first();
            if (!$member) {
                $member = new OrganisationMember();
                $member->character_id = $characterId;
                $member->organisation_id = $organisation;
            }

            $member->role = Arr::get($data, 'role', null);
            $member->save();
        } catch (Exception $e) {
            Log::error('Invalid org member ' . $uuid . ' for plugin entity #' . $pluginEntity->id . ': ' . $e->getMessage());
        }
    }

    /**
     * @param MiscModel $model
     * @param PluginVersionEntity $entity
     * @return MiscModel
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function importImage(MiscModel $model, PluginVersionEntity $entity)
    {
        // Don't do anything if no image or replacing an image (too many false positives)
        if (empty($entity->image_path) || !empty($model->image)) {
            return $model;
        }

        // Need to download the image from the marketplace's s3 (if possible)
        try {
            $folder = $model->getTable();
            $path = $folder . '/' . Str::uuid() . '.' . Str::afterLast($entity->image_path, '.');
            //dump($path);
            Storage::writeStream($path, Storage::disk('s3-marketplace')->readStream($entity->image_path));
            $model->image = $path;
        } catch (Exception $e) {
            Log::error('Error importing image from ' . $entity->id . ': ' . $e->getMessage());
        }

        return $model;
    }

    protected function importBlock(string $block, array $values = null, MiscModel $model)
    {
        if (empty($values)) {
            return;
        }

        /** @var CharacterTrait[] $existing */
        $existing = [];
        foreach ($model->characterTraits()->{$block}()->get() as $pers) {
            $existing[$pers->name] = $pers;
        }
        foreach ($values as $name => $value) {
            if (isset($existing[$name])) {
                $existing[$name]->entry = $value;
                $existing[$name]->save();
            } else {
                CharacterTrait::create([
                    'character_id' => $model->id,
                    'section' => $block,
                    'name' => $name,
                    'entry' => $value
                ]);
            }
        }
    }

    /**
     * @param int $id
     */
    protected function getEntityId(int $id)
    {
        return $this->entityIds[$id];
    }

    /**
     * Load
     * @param MiscModel $misc
     */
    protected function loadRelations(MiscModel $misc)
    {
        $this->loadedRelations = [];
        /** @var Relation $relation */
        foreach ($misc->entity->relationships()->whereNotNull('marketplace_uuid')->get() as $relation) {
            if (empty($relation->marketplace_uuid)) {
                continue;
            }
            $this->loadedRelations[$relation->marketplace_uuid] = $relation;
        }
    }
}
