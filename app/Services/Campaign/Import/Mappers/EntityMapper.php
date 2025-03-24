<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Enums\Visibility;
use App\Facades\EntityLogger;
use App\Facades\ImportIdMapper;
use App\Models\Attribute;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityMention;
use App\Models\EntityTag;
use App\Models\Image;
use App\Models\Inventory;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Relation;
use App\Models\Reminder;
use App\Services\EntityMappingService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait EntityMapper
{
    protected array $mapping = [];

    protected array $parents = [];

    protected Entity $entity;

    protected mixed $model;

    protected EntityMappingService $entityMappingService;

    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    protected function prepareModel(): self
    {
        $this->model = app()->make($this->className);
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            // @phpstan-ignore-next-line
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }

        $this->model->saveQuietly();
        $this->entity();

        return $this;
    }

    protected function loadModel(): self
    {
        $builder = app()->make($this->className);
        $id = ImportIdMapper::get($this->mappingName, $this->data['id']);
        $this->model = $builder->where('id', $id)->with('entity')->firstOrFail();
        $this->entity = $this->model->entity;

        return $this;
    }

    protected function trackMappings(?string $parent = null): void
    {
        $this->mapping[$this->data['id']] = $this->model->id;
        ImportIdMapper::put($this->mappingName, $this->data['id'], $this->model->id);
        if ($parent && ! empty($this->data[$parent])) {
            $this->parents[$this->data[$parent]][] = $this->model->id;
        }
    }

    protected function entity(): void
    {
        $mapping = ['name', 'is_private', 'campaign_id'];
        $entityMapping = ['tooltip', 'is_template', 'is_attributes_private', 'focus_x', 'focus_y', 'entry', 'type', 'type_id'];
        $this->entity = new Entity;
        $this->entity->entity_id = $this->model->id;
        $this->entity->created_by = $this->user->id;
        $this->entity->updated_by = $this->user->id;
        foreach ($mapping as $field) {
            $this->entity->$field = $this->model->$field;
        }
        // Old exports might not have this info so we call back on the model hardcoded ids
        if (empty($this->entity->type_id)) {
            $this->entity->type_id = $this->model->entityTypeId();
        }
        foreach ($entityMapping as $field) {
            $this->entity->$field = $this->data['entity'][$field];
        }

        $this
            ->images()
            ->gallery();
        $this->entity->save();

        EntityLogger::entity($this->entity)->create();

        ImportIdMapper::putEntity($this->data['entity']['id'], $this->entity->id);

        $this
            ->assets()
            ->tags();
    }

    public function second(): void
    {
        $this
            ->loadModel()
            ->entitySecond();
    }

    protected function entitySecond(): void
    {
        $this->entity = $this->model->entity;

        $this->entity->tooltip = $this->mentions($this->entity->tooltip);
        $this->entity->entry = $this->mentions($this->entity->entry);
        $this->entity->save();

        $this->posts()
            ->attributes()
            ->relations()
            ->reminders()
            ->abilities()
            ->inventory();
    }

    protected function entityThird(): void
    {
        $this->entity = $this->model->entity;

        $this
            ->foreignMentions();
    }

    /**
     * Migrate old entity image system to the gallery.
     */
    protected function images(): self
    {
        $oldImages = ['image_path', 'header_image'];
        foreach ($oldImages as $old) {
            $this->migrateToGallery($old);
        }

        return $this;
    }

    protected function migrateToGallery(string $old): self
    {
        $img = Arr::get($this->data, 'entity.' . $old);

        if (empty($img) || ! Storage::disk('local')->exists($this->path . $img)) {
            return $this;
        }

        $image = $this->migrateImage($img);

        if ($old == 'image_path') {
            $this->entity->image_uuid = ImportIdMapper::getGallery($image->id);
        } else {
            $this->entity->header_uuid = ImportIdMapper::getGallery($image->id);
        }

        return $this;
    }

    protected function migrateImage(string $img): Image
    {
        $imageExt = Str::after($img, '.');

        // We need to create a new Image to migrate to the new system.
        $image = new Image;
        $image->campaign_id = $this->campaign->id;
        $image->ext = $imageExt;
        $image->name = $this->entity->name;
        $image->visibility_id = Visibility::All;
        $size = Storage::disk('local')->size($this->path . $img);
        $image->size = (int) ceil($size / 1024); // kb
        $image->save();

        // Upload the file to s3 using streams
        Storage::writeStream($image->path, Storage::disk('local')->readStream($this->path . $img));
        ImportIdMapper::putGallery($image->id, $image->id);

        return $image;
    }

    protected function gallery(): self
    {
        $image = Arr::get($this->data, 'entity.image_uuid');
        if (! empty($image)) {
            $this->entity->image_uuid = ImportIdMapper::getGallery($image);
        }
        $image = Arr::get($this->data, 'entity.header_uuid');
        if (! empty($image)) {
            $this->entity->header_uuid = ImportIdMapper::getGallery($image);
        }

        return $this;
    }

    protected function posts(): self
    {
        if (empty($this->data['entity']['posts'])) {
            return $this;
        }

        $import = [
            'name',
            'entry',
            'is_private',
            'visibility_id',
            'position',
            'settings',
            'layout_id',
        ];
        foreach ($this->data['entity']['posts'] as $data) {
            $post = new Post;
            $post->entity_id = $this->entity->id;
            foreach ($import as $field) {
                $post->$field = $data[$field];
            }
            if (! empty($data['location_id']) && ImportIdMapper::has('locations', $data['location_id'])) {
                $locationID = ImportIdMapper::get('locations', $data['location_id']);
                if (! empty($locationID)) {
                    $post->location_id = $locationID;
                }
            }
            if (empty($post->position)) {
                $post->position = 0;
            }

            $post->entry = $this->mentions($post->entry);
            $post->created_by = $this->user->id;
            $post->save();

            if (array_key_exists('postTags', $data)) {
                foreach ($data['postTags'] as $oldTag) {
                    if (! ImportIdMapper::has('tags', $oldTag['tag_id'])) {
                        continue;
                    }
                    $tagID = ImportIdMapper::get('tags', $oldTag['tag_id']);
                    $postTag = new PostTag;
                    $postTag->post_id = $post->id;
                    $postTag->tag_id = $tagID;
                    $postTag->save();
                }
            }

            ImportIdMapper::putPost($data['id'], $post->id);
            $this->mapImageMentions($post);
        }

        return $this;
    }

    protected function assets(): self
    {
        if (empty($this->data['entity']['assets'])) {
            return $this;
        }

        $import = [
            'type_id',
            'visibility_id',
            'name',
            'position',
            'is_pinned',
        ];
        foreach ($this->data['entity']['assets'] as $data) {
            $asset = new EntityAsset;
            $asset->entity_id = $this->entity->id;

            foreach ($import as $field) {
                $asset->$field = $data[$field];
            }
            if (! empty($data['metadata'])) {
                if (! empty($data['metadata']['path'])) {
                    $img = $data['metadata']['path'];
                    if (! Storage::disk('local')->exists($this->path . $img)) {
                        // dd('image ' . $this->path . $img . ' doesnt exist');
                        continue;
                    }

                    $image = $this->migrateImage($img);
                    $asset->image_uuid = $image->id;
                    unset($data['metadata']['path']);
                    $asset->metadata = $data['metadata'];

                } else {
                    $asset->metadata = $data['metadata'];
                }
            }
            if (isset($data['image_uuid'])) {
                $asset->image_uuid = ImportIdMapper::getGallery($data['image_uuid']);
            }
            $asset->created_by = $this->user->id;
            $asset->save();
        }

        return $this;
    }

    protected function attributes(): self
    {
        if (empty($this->data['entity']['entityAttributes'])) {
            return $this;
        }

        $import = [
            'name',
            'value',
            'is_private',
            'default_order',
            'is_pinned',
            'type_id',
            'is_hidden',
        ];
        foreach ($this->data['entity']['entityAttributes'] as $data) {
            $attr = new Attribute;
            $attr->entity_id = $this->entity->id;

            foreach ($import as $field) {
                $attr->$field = $data[$field];
            }
            $attr->value = $this->mentions($attr->value);
            $attr->save();
        }

        return $this;
    }

    protected function tags(): self
    {
        if (empty($this->data['entity']['entityTags'])) {
            return $this;
        }

        foreach ($this->data['entity']['entityTags'] as $data) {
            if (! ImportIdMapper::has('tags', $data['tag_id'])) {
                continue;
            }
            $tagID = ImportIdMapper::get('tags', $data['tag_id']);
            $entityTag = new EntityTag;
            $entityTag->entity_id = $this->entity->id;
            $entityTag->tag_id = $tagID;
            $entityTag->save();
        }

        return $this;
    }

    protected function foreign(string $model, string $field): self
    {
        if (empty($this->data[$field])) {
            return $this;
        }
        if ($model === 'entities') {
            if (! ImportIdMapper::hasEntity($this->data[$field])) {
                return $this;
            }
            $foreignID = ImportIdMapper::getEntity($this->data[$field]);
        } else {
            if (! ImportIdMapper::has($model, $this->data[$field])) {
                return $this;
            }
            $foreignID = ImportIdMapper::get($model, $this->data[$field]);
        }
        if (! $foreignID) {
            return $this;
        }
        $this->model->$field = $foreignID;

        return $this;
    }

    protected function pivot(string $relation, string $model, string $field): self
    {
        // Check if import has old location_id and migrate it to new locations pivot table system, currently only happens with organisations
        if ($relation == 'pivotLocations' && isset($this->data['location_id']) && ! in_array(['location_id' => $this->data['location_id']], $this->data[$relation])) {
            $this->data[$relation][] = ['location_id' => $this->data['location_id']];
        }
        foreach ($this->data[$relation] as $pivot) {
            if (! ImportIdMapper::has($model, $pivot[$field])) {
                continue;
            }
            $foreignID = ImportIdMapper::get($model, $pivot[$field]);
            if (array_key_exists('is_private', $pivot)) {
                $this->model->{$model}()->attach($foreignID, ['is_private' => $pivot['is_private']]);
            } else {
                $this->model->{$model}()->attach($foreignID);
            }
        }

        return $this;
    }

    protected function saveModel(): self
    {
        $this->model->save();
        $this->mapImageMentions($this->model);

        return $this;
    }

    protected function relations(): self
    {
        if (empty($this->data['entity']['relationships'])) {
            return $this;
        }

        $fields = [
            'relation', 'visibility_id', 'attitude', 'is_pinned', 'colour', 'marketplace_uuid',
        ];
        foreach ($this->data['entity']['relationships'] as $data) {
            if (! ImportIdMapper::hasEntity($data['target_id'])) {
                continue;
            }
            $targetID = ImportIdMapper::getEntity($data['target_id']);
            $rel = new Relation;
            $rel->owner_id = $this->entity->id;
            $rel->target_id = $targetID;
            $rel->campaign_id = $this->campaign->id;
            $rel->created_by = $this->user->id;
            foreach ($fields as $field) {
                $rel->$field = $data[$field];
            }
            $rel->save();
        }

        return $this;
    }

    protected function reminders(): self
    {

        if (empty($this->data['entity']['events'])) {
            return $this;
        }
        $fields = [
            'length',
            'comment',
            'is_recurring',
            'recurring_until',
            'recurring_periodicity',
            'colour',
            'day',
            'month',
            'year',
            'type_id',
            'visibility_id',
        ];
        foreach ($this->data['entity']['events'] as $data) {
            if (! ImportIdMapper::has('calendars', $data['calendar_id'])) {
                continue;
            }
            $rem = new Reminder;
            $rem->remindable_type = Entity::class;
            $rem->remindable_id = $this->entity->id;
            $rem->calendar_id = ImportIdMapper::get('calendars', $data['calendar_id']);
            foreach ($fields as $field) {
                $rem->$field = $data[$field];
            }
            $rem->created_by = $this->user->id;
            $rem->save();
        }

        return $this;
    }

    protected function abilities(): self
    {
        if (empty($this->data['entity']['abilities'])) {
            return $this;
        }

        $fields = [
            'visibility_id', 'charges', 'position', 'note',
        ];
        foreach ($this->data['entity']['abilities'] as $data) {
            if (! ImportIdMapper::has('abilities', $data['ability_id'])) {
                continue;
            }
            $abilityID = ImportIdMapper::get('abilities', $data['ability_id']);
            if (empty($abilityID)) {
                continue;
            }

            $ab = new EntityAbility;
            $ab->entity_id = $this->entity->id;
            $ab->ability_id = $abilityID;
            $ab->created_by = $this->user->id;
            foreach ($fields as $field) {
                $ab->$field = $data[$field];
            }
            $ab->save();
        }

        return $this;
    }

    protected function inventory(): self
    {
        if (empty($this->data['entity']['inventories'])) {
            return $this;
        }
        $fields = [
            'name',
            'amount',
            'position',
            'description',
            'visibility_id',
            'is_equipped',
            'copy_item_entry',
        ];
        foreach ($this->data['entity']['inventories'] as $data) {

            $inv = new Inventory;
            $inv->entity_id = $this->entity->id;
            if (! empty($data['item_id'])) {
                if (! ImportIdMapper::has('items', $data['item_id'])) {
                    continue;
                }
                $itemID = ImportIdMapper::get('items', $data['item_id']);
                if (empty($itemID)) {
                    continue;
                }
                $inv->item_id = $itemID;
            }
            $inv->created_by = $this->user->id;
            foreach ($fields as $field) {
                $inv->$field = $data[$field];
            }
            $inv->save();
        }

        return $this;
    }

    protected function foreignMentions(): self
    {
        if (empty($this->data['entity']['mentions'])) {
            return $this;
        }

        foreach ($this->data['entity']['mentions'] as $data) {
            if (! ImportIdMapper::hasEntity($data['target_id'])) {
                continue;
            }
            $men = new EntityMention;
            $men->entity_id = $this->entity->id;
            $men->target_id = ImportIdMapper::getEntity($data['target_id']);
            if (! empty($data['campaign_id'])) {
                $men->campaign_id = $this->campaign->id;
            } elseif (! empty($data['post_id'])) {
                $men->post_id = ImportIdMapper::getPost($data['post_id']);
            } elseif (! empty($data['timeline_element_id'])) {
                $men->timeline_element_id = ImportIdMapper::getTimelineElement($data['timeline_element_id']);
            } elseif (! empty($data['quest_element_id'])) {
                $men->quest_element_id = ImportIdMapper::getQuestElement($data['quest_element_id']);
            }
            $men->save();
        }

        return $this;
    }
}
