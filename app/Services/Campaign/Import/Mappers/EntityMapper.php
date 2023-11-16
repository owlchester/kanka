<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Attribute;
use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\EntityAbility;
use App\Models\EntityAsset;
use App\Models\EntityEvent;
use App\Models\EntityTag;
use App\Models\MiscModel;
use App\Models\Post;
use App\Models\Relation;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait EntityMapper
{
    protected array $mapping = [];
    protected array $parents = [];
    protected Entity $entity;
    protected mixed $model;

    protected function prepareModel(): self
    {
        $this->model = app()->make($this->className);
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }

        $this->model->slug = Str::slug($this->model->name);
        $this->model->save();
        $this->entity();

        return $this;
    }

    protected function loadModel(): self
    {
        $builder = app()->make($this->className);
        $id = ImportIdMapper::get($this->mappingName, $this->data['id']);
        $this->model = $builder->where('id', $id)->firstOrFail();
        return $this;
    }

    protected function trackMappings(string $parent = null): void
    {
        $this->mapping[$this->data['id']] = $this->model->id;
        ImportIdMapper::put($this->mappingName, $this->data['id'], $this->model->id);
        if ($parent && !empty($this->data[$parent])) {
            $this->parents[$this->data[$parent]][] = $this->model->id;
        }
    }

    protected function entity(): void
    {
        $mapping = ['name', 'is_private', 'campaign_id'];
        $entityMapping = ['tooltip', 'is_template', 'is_attributes_private', 'focus_x', 'focus_y'];
        $this->entity = new Entity();
        $this->entity->entity_id = $this->model->id;
        $this->entity->type_id = $this->model->entityTypeId();
        $this->entity->created_by = $this->user->id;
        $this->entity->updated_by = $this->user->id;
        foreach ($mapping as $field) {
            $this->entity->$field = $this->model->$field;
        }
        foreach ($entityMapping as $field) {
            $this->entity->$field = $this->data['entity'][$field];
        }

        $this
            ->image()
            ->header()
            ->gallery();
        $this->entity->save();

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
        $this->entity->save();

        $this->posts()
            ->attributes()
            ->relations()
            ->reminders()
            ->abilities()
            ->inventory()
        ;
    }

    protected function image(): self
    {
        $img = Arr::get($this->data, 'entity.image_path');
        if (empty($img)) {
            return $this;
        }

        // An image needs the image saved locally
        $imageName = Str::after($img, '/');
        $destination = 'w/' . $this->campaign->id . '/' . $imageName;

        if (!Storage::disk('local')->exists($this->path . $img)) {
            dd('image ' . $this->path . $img . ' doesnt exist');
            return $this;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $img));
        $this->entity->image_path = $destination;
        return $this;
    }

    protected function header(): self
    {
        $img = Arr::get($this->data, 'entity.header_image');
        if (empty($img)) {
            return $this;
        }

        // An image needs the image saved locally
        $imageName = Str::afterLast($img, '/');
        $destination = 'w/' . $this->campaign->id . '/' . $imageName;

        if (!Storage::disk('local')->exists($this->path . $img)) {
            dd('header image ' . $this->path . $img . ' doesnt exist');
            return $this;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $img));
        $this->entity->header_image = $destination;
        return $this;
    }

    protected function gallery(): self
    {
        $image = Arr::get($this->data, 'entity.image_uuid');
        if (!empty($image)) {
            $this->entity->image_uuid = ImportIdMapper::getGallery($image);;
        }
        $image = Arr::get($this->data, 'entity.header_uuid');
        if (!empty($image)) {
            $this->entity->header_uuid = ImportIdMapper::getGallery($image);;
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
            $post = new Post();
            $post->entity_id = $this->entity->id;
            foreach ($import as $field) {
                $post->$field = $data[$field];
            }
            if (!empty($data['location_id'])) {
                $locationID = ImportIdMapper::get('locations', $data['location_id']);
                if (!empty($locationID)) {
                    $post->location_id = $locationID;
                }
            }

            $post->entry = $this->mentions($post->entry);
            $post->created_by = $this->user->id;
            $post->save();
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
            $asset = new EntityAsset();
            $asset->entity_id = $this->entity->id;

            foreach ($import as $field) {
                $asset->$field = $data[$field];
            }
            if (!empty($data['metadata'])) {
                if (!empty($data['metadata']['path'])) {
                    $img = $data['metadata']['path'];
                    $ext = Str::afterLast($img, '.');
                    $destination = 'w/' . $this->campaign->id . '/entity-assets/' . uniqid() . '.' . $ext;

                    if (!Storage::disk('local')->exists($this->path . $img)) {
                        dd('image ' . $this->path . $img . ' doesnt exist');
                        continue;
                    }
                    Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $img));
                    $data['metadata']['path'] = $destination;
                    $asset->metadata = $data['metadata'];
                } else {
                    $asset->metadata = $data['metadata'];
                }
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
            $attr = new Attribute();
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
            $tagID = ImportIdMapper::get('tags', $data['tag_id']);
            $entityTag = new EntityTag();
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
            $foreignID = ImportIdMapper::getEntity($this->data[$field]);
        } else {
            $foreignID = ImportIdMapper::get($model, $this->data[$field]);
        }
        if (!$foreignID) {
            return $this;
        }
        $this->model->$field = $foreignID;
        return $this;
    }

    protected function pivot(string $relation, string $model, string $field): self
    {
        foreach ($this->data[$relation] as $pivot) {
            $foreignID = ImportIdMapper::get($model, $pivot[$field]);
            if (!$foreignID) {
                continue;
            }
            $this->model->{$model}()->attach($foreignID);
        }
        return $this;
    }

    protected function saveModel(): self
    {
        $this->model->entry = $this->mentions($this->model->entry);
        $this->model->save();
        return $this;
    }

    protected function relations(): self
    {
        if (empty($this->data['entity']['relationships'])) {
            return $this;
        }

        $fields = [
            'relation', 'visibility_id', 'attitude', 'is_pinned', 'colour', 'marketplace_uuid'
        ];
        foreach ($this->data['entity']['relationships'] as $data) {
            $targetID = ImportIdMapper::getEntity($data['target_id']);
            if (empty($targetID)) {
                continue;
            }

            $rel = new Relation();
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
            $rem = new EntityEvent();
            $rem->entity_id = $this->entity->id;
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
            'visibility_id', 'charges', 'position', 'note'
        ];
        foreach ($this->data['entity']['abilities'] as $data) {
            $abilityID = ImportIdMapper::get('abilities', $data['ability_id']);
            if (empty($abilityID)) {
                continue;
            }

            $ab = new EntityAbility();
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
        if (empty($this->data['entity']['inventory'])) {
            return $this;
        }

        dd('inventory, uh oh');
        return $this;
    }

    protected function mentions(string|null $text): string|null
    {
        if (empty($text)) {
            return $text;
        }

        return preg_replace_callback(
            '`\[([a-z_]+):(.*?)\]`i',
            function ($matches) {
                $segments = explode('|', $matches[2]);
                $oldEntityID = (int) $segments[0];
                $entityType = $matches[1];

                if (!ImportIdMapper::hasEntity($oldEntityID)) {
                    return $matches[0];
                }
                $entityID = ImportIdMapper::getEntity($oldEntityID);

                if (Str::contains($matches[2], '|')) {
                    return '[' . $entityType . ':' . Str::replace($oldEntityID . '|', $entityID . '|', $matches[2]);
                }
                return '[' . $entityType . ':' . $entityID . ']';
            },
            $text
        );
    }

    public function fixTree(): self
    {
        $base = app()->make($this->className);
        if (!method_exists($base, 'recalculateTreeBounds')) {
            return $this;
        }
        $base->fixCampaignTree($this->campaign->id);
        return $this;
    }
}
