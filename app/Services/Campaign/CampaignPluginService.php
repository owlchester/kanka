<?php


namespace App\Services\Campaign;


use App\Facades\CampaignCache;
use App\Http\Resources\QuestElementResource;
use App\Models\Campaign;
use App\Models\CampaignPlugin;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\EntityNote;
use App\Models\EntityTag;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Models\Plugin;
use App\Models\PluginVersion;
use App\Models\PluginVersionEntity;
use App\Models\QuestCharacter;
use App\Models\QuestElement;
use App\Models\QuestItem;
use App\Models\QuestLocation;
use App\Models\QuestOrganisation;
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

    /** @var array */
    protected $loadedPosts = [];

    /** @var null|Collection */
    protected $importedEntities = null;

    /** @var array updated entities */
    protected $updated = [];

    /** @var array created entities */
    protected $created = [];

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
        $model = null;
        $entity = $this->importedEntities->where('marketplace_uuid', $pluginEntity->uuid)->first();
        if ($entity) {
            $this->entityIds[$pluginEntity->id] = $entity->id;
            $this->miscIds[$pluginEntity->id] = $entity->entity_id;
            $this->entityTypes[$pluginEntity->id] = $entity->type;
            //dump('existing ' . $pluginEntity->uuid);
            $model = $entity->child;

            $this->updated[] = link_to($entity->url(), $entity->name);
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

            $this->created[] = link_to($entity->url(), $model->name);
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
                } elseif(isset($this->miscIds[$value])) {
                    $model->$field = $this->miscIds[$value];
                }
            } elseif (in_array($field, $blocks)) {
                $this->importBlock($field, $value, $model);
            } elseif ($field == 'tags') {
                $this->importTags($value, $model);
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
            $this->loadRelations($model);
            foreach ($pluginEntity->related as $type => $fields) {
                foreach ($fields as $uuid => $data) {
                    if ($type == 'relation') {
                        $this->saveRelation($data, $uuid, $entityId);
                    } elseif ($type == 'member') {
                        $this->saveOrganisationMember($data, $uuid, $model->id, $pluginEntity);
                    } elseif ($type == 'quest_element') {
                        $this->saveQuestElement($data, $uuid, $model->id, $pluginEntity);
                    } else {
                        Log::info('Unknown relation type \'' . $type . '\' for marketplace entity #' . $pluginEntity->id);
                    }
                }
            }
        }

        $this->importPosts($pluginEntity, $entityId);
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
     * @param array $data
     * @param string $uuid
     * @param int $questId
     * @param PluginVersionEntity $pluginEntity
     */
    protected function saveQuestElement(array $data, string $uuid, int $questId, PluginVersionEntity $pluginEntity)
    {
        //dump('importing a quest element.');

        // Determine what we're adding
        $target = $this->entityIds[$data['target']];

        //dump("want to add target $target ($targetType) as a $class to $questId");

        // Does it exist?
        try {
            $element = QuestElement::where('quest_id', $questId)->where('entity_id', $target)->first();
            if (empty($element)) {
                /** @var QuestElement $element */
                $element = new QuestElement();
                $element->quest_id = $questId;
                $element->entity_id = $target;
            }
            $element->role = Arr::get($data, 'role', null);
            $element->description = $this->mentions(Arr::get($data, 'description', ''));
            $element->visibility = 'all';
            //dd($element);
            $element->save();
        } catch(Exception $e) {
            Log::error('Invalid quest element ' . $uuid . ' for plugin entity #' . $pluginEntity->id . ' (entity #' . $target . '): ' . $e->getMessage());
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

    /**
     * @param string $block
     * @param array|null $values
     * @param MiscModel $model
     */
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
                    'section_id' => $block == 'appearance' ?
                        CharacterTrait::SECTION_APPEARANCE : CharacterTrait::SECTION_PERSONALITY,
                    'name' => $name,
                    'entry' => $value
                ]);
            }
        }
    }


    protected function importTags(array $values = null, MiscModel $model)
    {
        if (empty($values)) {
            return;
        }
        $real = [];
        foreach ($values as $val) {
            if (!empty($val)) {
                $real[] = $val;
            }
        }
        if (empty($real)) {
            return;
        }

        // Importing tags for

        // Get existing tags on this entity
        $existing = $model->entity->tags->pluck('id')->toArray();

        foreach ($real as $tag) {
            // Tag doesn't properly exist, skip
            if (!isset($this->miscIds[$tag])) {
                continue;
            }
            $target = $this->miscIds[$tag];
            if (in_array($target, $existing)) {
                continue;
            }

            $new = new EntityTag();
            $new->entity_id = $model->entity->id;
            $new->tag_id = $target;
            $new->save();
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

    /**
     * @param int $entityId
     */
    protected function loadPosts(int $entityId)
    {
        $this->loadedPosts = [];
        $posts = EntityNote::where('entity_id', $entityId)
            ->whereNotNull('marketplace_uuid')
            ->get();

        /** @var EntityNote $post */
        foreach ($posts as $post) {
            $this->loadedPosts[$post->marketplace_uuid] = $post;
        }
    }

    /**
     * @param string $text
     * @return string
     */
    protected function mentions(string $text): string
    {
        return preg_replace_callback('`\[entity:(.*?)\]`i', function ($matches) {
            $id = (int) $matches[1];
            if (empty($id) || !isset($this->entityIds[$id])) {
                return 'wat';
            }

            return '[' . $this->entityTypes[$id] . ':' . $this->entityIds[$id] . ']';
        }, $text);
    }

    /**
     * List of created entities
     * @return string
     */
    public function created(): string
    {
        return (string) implode(', ', $this->created);
    }


    /**
     * List of created entities
     * @return string
     */
    public function updated(): string
    {
        return (string) implode(', ', $this->updated);
    }

    /**
     * @param PluginVersionEntity $entity
     * @param int $entityId
     */
    protected function importPosts(PluginVersionEntity $entity, int $entityId)
    {
        if (empty($entity->posts)) {
            return;
        }

        $this->loadPosts($entityId);

        foreach ($entity->posts as $uuid => $data) {
            $post = $this->loadedPosts[$uuid] ?? null;
            if (empty($post)) {
                $post = new EntityNote();
                $post->entity_id = $entityId;
                $post->marketplace_uuid = $uuid;
            }

            $post->name = Arr::get($data, 'name');
            $post->entry = $this->mentions(Arr::get($data, 'entry'));
            $post->visibility = Arr::get($data, 'visibility');
            $post->save();
        }
    }
}
