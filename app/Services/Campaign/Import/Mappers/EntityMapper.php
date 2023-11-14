<?php

namespace App\Services\Campaign\Import\Mappers;

use _PHPStan_c6b09fbdf\Nette\PhpGenerator\Attribute;
use App\Facades\ImportIdMapper;
use App\Models\Entity;
use App\Models\EntityAsset;
use App\Models\EntityTag;
use App\Models\Post;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait EntityMapper
{
    protected array $mapping = [];
    protected array $parents = [];
    protected Entity $entity;
    protected mixed $model;

    protected function prepareModel(string $model): self
    {
        $this->model = app()->make($model);
        $this->model->campaign_id = $this->campaign->id;
        foreach ($this->data as $field => $value) {
            if (is_array($value) || in_array($field, $this->ignore)) {
                continue;
            }
            $this->model->$field = $value;
        }

        $this->model->save();
        $this->entity();

        return $this;
    }

    protected function trackMappings(string $class, string $parent = null): void
    {
        $this->mapping[$this->data['id']] = $this->model->id;
        ImportIdMapper::put($class, $this->data['id'], $this->model->id);
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
        foreach ($mapping as $field) {
            $this->entity->$field = $this->model->$field;
        }
        foreach ($entityMapping as $field) {
            $this->entity->$field = $this->data['entity'][$field];
        }

        $this->image();
        $this->gallery();
        $this->entity->save();

        ImportIdMapper::putEntity($this->data['entity']['id'], $this->entity->id);
        $this->posts()
            ->assets()
            ->attributes()
            ->tags();
    }

    protected function image(): void
    {
        $img = Arr::get($this->data, 'entity.image_path');
        if (empty($img)) {
            return;
        }

        // An image needs the image saved locally
        $imageName = Str::after($img, '/');
        $folder = Str::before($img, '/');

        $imagePath = $this->path . '/' . $imageName;
        $destination = 'w/' . $this->campaign->id . '/' . $imageName;

        if (!Storage::disk('local')->exists($this->path . $img)) {
            dd('image ' . $this->path . $img . ' doesnt exist');
            return;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $img));
        $this->entity->image_path = $destination;
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
            // todo: location_id
            //'location_id',
        ];
        foreach ($this->data['entity']['posts'] as $data) {
            $post = new Post();
            $post->entity_id = $this->entity->id;
            foreach ($import as $field) {
                $post->$field = $data[$field];
            }
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
            'is_pinned'
        ];
        foreach ($this->data['entity']['assets'] as $data) {
            $asset = new EntityAsset();
            $asset->entity_id = $this->entity->id;

            foreach ($import as $field) {
                $asset->$field = $data[$field];
            }
            if (!empty($data['metadata'])) {
                if (!empty($data['metadata']['path'])) {
                    dump('assets files need to be added to the export first');
                    continue;
                    $img = $data['metadata']['path'];
                    $ext = Str::afterLast($img, '.');
                    $destination = 'w/' . $this->campaign->id . '/entity-assets/' . uniqid() . '.' . $ext;

                    if (!Storage::disk('local')->exists($this->path . $img)) {
                        dd('image ' . $this->path . $img . ' doesnt exist');
                        continue;
                    }
                    Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $img));
                } else {
                    $asset->metadata = $data['metadata'];
                }
            }
            $asset->save();
        }
        return $this;
    }

    protected function attributes(): self
    {
        if (empty($this->data['entityAttributes'])) {
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
        foreach ($this->data['entityAttributes'] as $data) {
            $attr = new Attribute();
            $attr->entity_id = $this->entity->id;

            foreach ($import as $field) {
                $attr->$field = $data[$field];
            }
            $attr->save();
        }

        dd('what now? its attributes time');
    }
    protected function tags(): self
    {
        if (empty($this->data['entity']['tags'])) {
            return $this;
        }

        foreach ($this->data['entity']['tags'] as $data) {
            $tagID = ImportIdMapper::get('tags', $data['id']);
            $entityTag = new EntityTag();
            $entityTag->entity_id = $this->entity->id;
            $entityTag->tag_id = $tagID;
            $entityTag->save();
        }

        return $this;
    }
}
