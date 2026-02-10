<?php

namespace App\Services\Plugins;

use App\Enums\Visibility;
use App\Events\Campaigns\Plugins\PluginImported;
use App\Models\CampaignPlugin;
use App\Models\Character;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\EntityTag;
use App\Models\Family;
use App\Models\Image;
use App\Models\MiscModel;
use App\Models\OrganisationMember;
use App\Models\Plugin;
use App\Models\PluginVersionEntity;
use App\Models\Post;
use App\Models\QuestElement;
use App\Models\Race;
use App\Models\Relation;
use App\Traits\CampaignAware;
use App\Traits\UserAware;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImporterService
{
    use CampaignAware;
    use UserAware;

    protected Plugin $plugin;

    protected array $loadedRelations = [];

    protected array $loadedPosts = [];

    protected Collection $importedEntities;

    /** updated entities */
    protected array $updated = [];

    /** created entities */
    protected array $created = [];

    /** entities that are to be skipped */
    protected array $skippedEntities = [];

    protected bool $forcePrivate = false;

    protected bool $skipUpdates = false;

    protected array $entityIds = [];

    protected array $miscIds = [];

    protected array $entityTypes = [];

    protected array $models = [];

    protected mixed $model;

    public function plugin(Plugin $plugin): self
    {
        $this->plugin = $plugin;

        return $this;
    }

    public function options(array $options): self
    {
        if (Arr::get($options, 'force_private', false)) {
            $this->forcePrivate = true;
        }
        if (Arr::get($options, 'only_new', false)) {
            $this->skipUpdates = true;
        }

        return $this;
    }

    /**
     * Import a content pack's entities into the campaign.
     */
    public function import()
    {
        if (! $this->plugin->isContentPack()) {
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

        PluginImported::dispatch($campaignPlugin, $this->user);

        return $count;
    }

    protected function importModel(PluginVersionEntity $pluginEntity)
    {
        // Updating?
        /** @var ?Entity $model */
        $model = null;
        /** @var ?Entity $entity */
        $entity = $this->importedEntities
            ->where('marketplace_uuid', $pluginEntity->uuid)
            ->where('type_id', $pluginEntity->type_id)
            ->first();
        /** @var ?Entity $modifiedEntity */
        $modifiedEntity = $this->importedEntities
            ->where('marketplace_uuid', $pluginEntity->uuid)
            ->first();

        if ($entity) {
            $this->entityIds[$pluginEntity->id] = $entity->id;
            $this->miscIds[$pluginEntity->id] = $entity->entity_id;
            $this->entityTypes[$pluginEntity->id] = $entity->entityType->code;
            // dump('existing ' . $pluginEntity->uuid);
            $model = $entity->child;

            if (! $this->skipUpdates) {
                $this->updated[] = '<a href="' . $entity->url() . '" class="text-link">' . $entity->name . '</a>';
            } else {
                $this->skippedEntities[] = $pluginEntity->id;
            }
        } else {
            if ($modifiedEntity) {
                $modifiedEntity->marketplace_uuid = null;
                $modifiedEntity->save();
            }
            $className = '\App\Models\\' . Str::studly($pluginEntity->type->code);
            // dump('new ' . $className);

            /** @var MiscModel $model */
            $model = new $className;
            $model->name = $pluginEntity->name;
            // $model->entry = $this->$pluginEntity->entry;
            $model->campaign_id = $this->campaign->id;
            $model->save();

            $entity = $model->entity;
            $entity->marketplace_uuid = $pluginEntity->uuid;
            $entity->save();

            $this->miscIds[$pluginEntity->id] = $model->id;
            $this->entityTypes[$pluginEntity->id] = $model->entity->entityType->code;
            $this->entityIds[$pluginEntity->id] = $model->entity->id;

            $this->created[] = '<a href="' . $entity->url() . '" class="text-link">' . $entity->name . '</a>';
        }
        $this->models[$pluginEntity->id] = $model;
    }

    protected function importFields(PluginVersionEntity $pluginEntity): void
    {
        if (in_array($pluginEntity->id, $this->skippedEntities)) {
            return;
        }
        // dump('Parsing entity ' . $pluginEntity->name . ' #' . $pluginEntity->id . '');
        $this->model = $this->models[$pluginEntity->id];
        $entityId = $this->getEntityId($pluginEntity->id);
        // dump("entityId: $entityId");
        foreach ($pluginEntity->fields as $field => $value) {
            $this->importField($field, $value, $pluginEntity);
        }

        if ($this->forcePrivate) {
            $this->model->is_private = true;
        }

        $this->importImage($pluginEntity);

        // Mentions
        $this->model->entity->entry = preg_replace_callback('`\[entity:(.*?)\]`i', function ($matches) {
            $id = (int) $matches[1];
            if (empty($id) || ! isset($this->entityIds[$id])) {
                return 'wat';
            }

            return '[' . $this->entityTypes[$id] . ':' . $this->entityIds[$id] . ']';
        }, $pluginEntity->entry);

        $this->model->save();
        $this->model->entity->save();

        // Relations
        if (! empty($pluginEntity->related)) {
            $this->importRelations($pluginEntity, $entityId);
        }

        $this->importPosts($pluginEntity, $entityId);
    }

    protected function importField(string $field, mixed $value, PluginVersionEntity $pluginEntity): void
    {
        // dump("field $field => $value");
        // parent mapping
        if ($field == 'gender') {
            $field = 'sex';
        }
        // Foreign key
        if (Str::endsWith($field, '_id')) {
            $this->importForeign($field, $value);
        } elseif (in_array($field, ['personality', 'appearance'])) {
            $this->importBlock($field, $value);
        } elseif ($field == 'tags') {
            $this->importTags($value);
        } elseif ($field == 'tooltip') {
            $this->importEntityTooltip($value);
        } elseif ($field == 'type') {
            $this->importEntityType($value);
        } elseif ($field == 'is_private' && $this->forcePrivate) {
            // Skip
        } else {
            $this->model->$field = $value;
        }
    }

    protected function importForeign(string $field, mixed $value): void
    {
        if ($field == 'race_id' && $this->model instanceof Character) {
            $this->importCharacterRace($value);

            return;
        } elseif ($field == 'family_id' && $this->model instanceof Character) {
            $this->importCharacterFamily($value);

            return;
        }
        if (empty($value)) {
            $this->model->$field = null;
        } elseif (isset($this->miscIds[$value])) {
            $this->model->$field = $this->miscIds[$value];
        }
    }

    protected function importEntityTooltip(mixed $value): void
    {
        $this->model->entity->tooltip = $value;
    }

    protected function importEntityType(mixed $value): void
    {
        $this->model->entity->type = $value;
    }

    protected function importCharacterRace(mixed $value): void
    {
        if (empty($value)) {
            $this->model->races()->detach();
        } elseif (isset($this->miscIds[$value])) {
            $raceID = $this->miscIds[$value];
            $race = Race::find($raceID);
            if ($race) {
                $this->model->races()->attach($race);
            }
        }
    }

    protected function importCharacterFamily(mixed $value): void
    {
        if (empty($value)) {
            $this->model->families()->detach();
        } elseif (isset($this->miscIds[$value])) {
            $raceID = $this->miscIds[$value];
            $race = Family::find($raceID);
            if ($race) {
                $this->model->families()->attach($race);
            }
        }
    }

    protected function importRelations(mixed $pluginEntity, mixed $entityId): void
    {
        $this->loadRelations($this->model);
        foreach ($pluginEntity->related as $type => $fields) {
            foreach ($fields as $uuid => $data) {
                if ($type == 'relation') {
                    $this->saveRelation($data, $uuid, $entityId);
                } elseif ($type == 'member') {
                    $this->saveOrganisationMember($data, $uuid, $this->model->id, $pluginEntity);
                } elseif ($type == 'quest_element') {
                    $this->saveQuestElement($data, $uuid, $this->model->id, $pluginEntity);
                } else {
                    Log::info('Unknown relation type \'' . $type . '\' for marketplace entity #' . $pluginEntity->id);
                }
            }
        }
    }

    /**
     * Create or update a relation
     */
    protected function saveRelation(array $data, string $uuid, int $ownerId): void
    {
        // dump("New relation for $ownerId");
        // dump($data);

        $targetId = $this->getEntityId($data['target']);
        if (empty($targetId) || empty($data['relation'])) {
            return;
        }

        try {
            $relation = $this->loadedRelations[$uuid] ?? null;
            if (empty($relation)) {
                $relation = new Relation;
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

    protected function saveOrganisationMember(array $data, string $uuid, int $characterId, PluginVersionEntity $pluginEntity): void
    {
        // Check the target org
        // dump('adding org member for ' . $characterId);
        $organisation = $this->miscIds[$data['target']];
        if (empty($organisation)) {
            return;
        }

        // Look if already exists
        try {
            $member = OrganisationMember::where('character_id', $characterId)
                ->where('organisation_id', $organisation)
                ->first();
            if (! $member) {
                $member = new OrganisationMember;
                $member->character_id = $characterId;
                $member->organisation_id = $organisation;
            }

            $member->role = Arr::get($data, 'role', null);
            $member->save();
        } catch (Exception $e) {
            Log::error('Invalid org member ' . $uuid . ' for plugin entity #' .
                $pluginEntity->id . ': ' . $e->getMessage());
        }
    }

    protected function saveQuestElement(array $data, string $uuid, int $questId, PluginVersionEntity $pluginEntity): void
    {
        // dump('importing a quest element.');

        // Determine what we're adding
        $target = $this->entityIds[$data['target']];

        // dump("want to add target $target ($targetType) as a $class to $questId");

        // Does it exist?
        try {
            /** @var QuestElement $element */
            $element = QuestElement::where('quest_id', $questId)->where('entity_id', $target)->first();
            if (empty($element)) {
                $element = new QuestElement;
                $element->quest_id = $questId;
                $element->entity_id = $target;
            }
            $element->role = Arr::get($data, 'role', null);
            $element->entry = $this->mentions(Arr::get($data, 'description', ''));
            $element->visibility_id = Visibility::All;
            $element->save();
        } catch (Exception $e) {
            Log::error('Invalid quest element ' . $uuid . ' for plugin entity #' . $pluginEntity->id
                . ' (entity #' . $target . '): ' . $e->getMessage());
        }
    }

    /**
     * Images are stored in the campaign gallery and need to be mapped to their uuid
     */
    protected function importImage(PluginVersionEntity $entity): self
    {
        // Don't do anything if no image or replacing an image (too many false positives)
        if (empty($entity->image_path) || ! empty($this->model->entity->image_path) || ! empty($this->model->entity->image_uuid)) {
            return $this;
        }

        // Need to download the image from the marketplace's s3 (if possible)
        try {
            $imageExt = Str::afterLast($entity->image_path, '.');

            // We need to create a new Image to migrate to the new system. Maybe in the future
            // we can store the marketplace's uuid here and avoid duplicates.
            $image = new Image;
            $image->campaign_id = $this->campaign->id;
            $image->ext = $imageExt;
            $image->name = $entity->name;
            $image->visibility_id = Visibility::All;
            $size = Storage::disk('s3-marketplace')->size($entity->image_path);
            $image->size = (int) ceil($size / 1024); // kb
            $image->save();

            Storage::writeStream($image->path, Storage::disk('s3-marketplace')->readStream($entity->image_path));
            $this->model->entity->image_uuid = $image->id;
        } catch (Exception $e) {
            Log::error('Error importing image from ' . $entity->id . ': ' . $e->getMessage());
        }

        return $this;
    }

    protected function importBlock(string $block, ?array $values = null): void
    {
        if (empty($values)) {
            return;
        }

        /** @var CharacterTrait[] $existing */
        $existing = [];
        foreach ($this->model->characterTraits()->{$block}()->get() as $pers) {
            $existing[$pers->name] = $pers;
        }
        foreach ($values as $name => $value) {
            if (isset($existing[$name])) {
                $existing[$name]->entry = $value;
                $existing[$name]->save();
            } else {
                CharacterTrait::create([
                    'character_id' => $this->model->id,
                    'section_id' => $block == 'appearance' ?
                        CharacterTrait::SECTION_APPEARANCE : CharacterTrait::SECTION_PERSONALITY,
                    'name' => $name,
                    'entry' => $value,
                ]);
            }
        }
    }

    protected function importTags(?array $values = null): void
    {
        if (empty($values)) {
            return;
        }
        $real = [];
        foreach ($values as $val) {
            if (! empty($val)) {
                $real[] = $val;
            }
        }
        if (empty($real)) {
            return;
        }

        // Importing tags for

        // Get existing tags on this entity
        $existing = $this->model->entity->tags->pluck('id')->toArray();

        foreach ($real as $tag) {
            // Tag doesn't properly exist, skip
            if (! isset($this->miscIds[$tag])) {
                continue;
            }
            $target = $this->miscIds[$tag];
            if (in_array($target, $existing)) {
                continue;
            }

            $new = new EntityTag;
            $new->entity_id = $this->model->entity->id;
            $new->tag_id = $target;
            $new->save();
        }
    }

    protected function getEntityId(int $id)
    {
        return $this->entityIds[$id];
    }

    /**
     * Load
     */
    protected function loadRelations(MiscModel $misc): void
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

    protected function loadPosts(int $entityId): void
    {
        $this->loadedPosts = [];
        $posts = Post::where('entity_id', $entityId)
            ->whereNotNull('marketplace_uuid')
            ->get();

        /** @var Post $post */
        foreach ($posts as $post) {
            $this->loadedPosts[$post->marketplace_uuid] = $post;
        }
    }

    protected function mentions(string $text): string
    {
        return preg_replace_callback('`\[entity:(.*?)\]`i', function ($matches) {
            $id = (int) $matches[1];
            if (empty($id) || ! isset($this->entityIds[$id])) {
                return 'wat';
            }

            return '[' . $this->entityTypes[$id] . ':' . $this->entityIds[$id] . ']';
        }, $text);
    }

    /**
     * List of created entities
     */
    public function created(): string
    {
        return (string) implode(', ', $this->created);
    }

    /**
     * List of created entities
     */
    public function updated(): string
    {
        return (string) implode(', ', $this->updated);
    }

    protected function importPosts(PluginVersionEntity $entity, int $entityId): void
    {
        if (empty($entity->posts)) {
            return;
        }

        $this->loadPosts($entityId);

        foreach ($entity->posts as $uuid => $data) {
            $post = $this->loadedPosts[$uuid] ?? null;
            if (empty($post)) {
                $post = new Post;
                $post->entity_id = $entityId;
                $post->marketplace_uuid = $uuid;
            }

            $visibility = Visibility::All->value;

            if (Arr::get($data, 'visibility') == 'admin') {
                $visibility = Visibility::Admin->value;
            } elseif (Arr::get($data, 'visibility') == 'admin-self') {
                $visibility = Visibility::AdminSelf->value;
            } elseif (Arr::get($data, 'visibility') == 'members') {
                $visibility = Visibility::Member->value;
            } elseif (Arr::get($data, 'visibility') == 'self') {
                $visibility = Visibility::Self->value;
            }

            $post->name = Arr::get($data, 'name');
            $post->entry = $this->mentions(Arr::get($data, 'entry'));
            $post->visibility_id = $visibility;
            $post->save();
        }
    }

    protected function campaignPlugin(): ?CampaignPlugin
    {
        return CampaignPlugin::where('campaign_id', $this->campaign->id)
            ->where('plugin_id', $this->plugin->id)
            ->first();
    }
}
