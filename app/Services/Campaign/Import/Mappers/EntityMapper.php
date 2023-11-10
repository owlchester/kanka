<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Entity;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait EntityMapper
{
    protected Entity $entity;

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
        $this->gallery()
            ->posts()
            ->assets()
            ->attributes();
        $this->entity->save();
    }

    protected function image(): void
    {
        if (empty($this->data['entity.image_path'])) {
            return;
        }

        // An image needs the image saved locally
        $imageName = Str::after($this->data['entity.image_path'], '/');
        $folder = Str::before($this->data['entity.image_path'], '/');

        $imagePath = $this->path . '/' . $imageName;
        $destination = 'w/' . $this->campaign->id . '/' . $folder . '/' . $imageName;

        if (!Storage::disk('local')->exists($imagePath)) {
            dd('image ' . $imagePath . ' doesnt exist');
            return;
        }

        // Upload the file to s3 using streams
        Storage::writeStream($destination, Storage::disk('local')->readStream($imagePath));
        $this->entity->image_path = $destination;
    }
    protected function gallery(): self
    {
        $image = Arr::get($this->data, 'entity.image_uuid');
        if (!empty($image)) {
            $this->entity->image_uuid = $this->mapGallery($image);
        }
        $image = Arr::get($this->data, 'entity.header_uuid');
        if (!empty($image)) {
            $this->entity->header_uuid = $this->mapGallery($image);
        }
        return $this;
    }

    protected function posts(): self
    {
        if (empty($this->data['entity']['posts'])) {
            return $this;
        }

        dd('what now? its posting time');
    }

    protected function assets(): self
    {
        if (empty($this->data['entity']['assets'])) {
            return $this;
        }

        dd('what now? its assets time');
    }

    protected function attributes(): self
    {
        if (empty($this->data['entity']['attributes'])) {
            return $this;
        }

        dd('what now? its attributes time');
    }
}
