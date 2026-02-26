<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Facades\ImportIdMapper;
use App\Models\Map;
use App\Models\MapGroup;
use App\Models\MapLayer;
use App\Models\MapMarker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MapMapper extends MiscMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'map_id', 'created_at', 'updated_at', 'location_id', 'center_marker_id'];

    protected string $className = Map::class;

    protected string $mappingName = 'maps';

    protected array $layers;

    protected array $groups;

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('map_id');
    }

    public function second(): void
    {
        // @phpstan-ignore-next-line
        $this->loadModel()
            ->foreign('locations', 'location_id')
            ->groups()
            ->groupsParents()
            ->layers()
            ->markers()
            ->entitySecond();
    }

    public function tree(): self
    {
        foreach ($this->parents as $parent => $children) {
            if (! isset($this->mapping[$parent])) {
                continue;
            }
            // We need the nested trait to trigger for this so it's going to be inefficient
            $maps = Map::whereIn('id', $children)->get();
            /** @var Map $model */
            foreach ($maps as $model) {
                $model->map_id = $this->mapping[$parent];
                $model->saveQuietly();
            }
        }

        return $this;
    }

    protected function groups(): self
    {
        $fields = [
            'name', 'position', 'visibility_id', 'is_shown',
        ];
        $this->groups = [];
        foreach ($this->data['groups'] as $data) {
            $el = new MapGroup;
            $el->map_id = $this->model->id;
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->created_by = $this->user->id;
            $el->save();
            $this->groups[$data['id']] = $el->id;
        }

        return $this;
    }

    protected function groupsParents(): self
    {
        foreach ($this->data['groups'] as $data) {
            if (isset($data['parent_id'])) {
                $group = MapGroup::where('id', $this->groups[$data['id']])->first();
                $group->parent_id = $this->groups[$data['parent_id']];
                $group->save();
            }
        }

        return $this;
    }

    protected function layers(): self
    {
        $fields = [
            'name', 'position', 'image_uuid', 'image_path', 'height', 'width', 'entry', 'visibility_id', 'type_id',
        ];
        $this->layers = [];
        foreach ($this->data['layers'] as $data) {
            $el = new MapLayer;
            $el->map_id = $this->model->id;
            foreach ($fields as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }
                $el->$field = $data[$field];
            }
            $el->entry = $this->mentions($el->entry);
            $el->created_by = $this->user->id;

            // Move image
            $imageField = isset($data['image_path']) ? 'image' : 'image_path';
            if (! empty($el->$imageField)) {
                $imageName = Str::afterLast($el->$imageField, '/');
                $destination = 'w/' . $this->campaign->id . '/maps/' . $el->map_id . '/' . $imageName;

                if (! Storage::disk('local')->exists($this->path . $el->$imageField)) {
                    Log::error('map layer image ' . $this->path . $el->$imageField . ' doesnt exist');

                    return $this;
                }

                // Upload the file to s3 using streams
                Storage::writeStream($destination, Storage::disk('local')->readStream($this->path . $el->$imageField));
                $el->image_path = $destination;
            } else {
                if (empty($el->image_uuid) || ! ImportIdMapper::hasGallery($el->image_uuid)) {
                    continue;
                }
                $el->image_uuid = ImportIdMapper::getGallery($el->image_uuid);
            }
            $el->save();
            $this->layers[$data['id']] = $el->id;
        }

        return $this;
    }

    protected function markers(): self
    {
        $fields = [
            'pin_size', 'name', 'entry', 'longitude', 'latitude', 'colour', 'shape_id', 'size_id', 'icon', 'custom_icon', 'custom_shape', 'is_draggable', 'visibility_id', 'font_colour', 'circle_radius', 'polygon_style', 'opacity', 'css',
        ];
        foreach ($this->data['markers'] as $data) {
            $marker = new MapMarker;
            $marker->map_id = $this->model->id;
            if (! empty($data['entity_id'])) {
                if (! ImportIdMapper::hasEntity($data['entity_id'])) {
                    continue;
                }
                $marker->entity_id = ImportIdMapper::getEntity($data['entity_id']);
            }
            foreach ($fields as $field) {
                if (isset($data[$field])) {
                    $marker->$field = $data[$field];
                }
            }

            if (! empty($data['group_id'])) {
                $marker->group_id = $this->groups[$data['group_id']];
            }

            $marker->created_by = $this->user->id;
            $marker->entry = $this->mentions($marker->entry);
            $marker->save();
        }

        return $this;
    }
}
