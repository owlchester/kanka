<?php

namespace App\Http\Resources;

use App\Facades\Mentions;
use App\Models\MiscModel;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    /** @var bool If the entity should come with related objects */
    public $withRelated = false;

    /**
     * Get related objects for this entity
     * @return $this
     */
    public function withRelated(): self
    {
        $this->withRelated = true;
        return $this;
    }

    public function toArray($request)
    {
        /** @var \App\Models\Entity $entity */
        $entity = $this->resource;
        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entity->type,
            'child_id' => $entity->id,
            'tags' => $entity->tags()->pluck('tags.id')->toArray(),
            'is_private' => (bool) $entity->is_private,
            'is_template' => (bool) $entity->is_template,
            'campaign_id' => $entity->campaign_id,
            'is_attributes_private' => (bool) $entity->is_attributes_private,
            'tooltip' => $entity->tooltip,
            'header_image' => $entity->header_image,

            'created_at' => $entity->created_at,
            'created_by' => $entity->created_by,
            'updated_at' => $entity->updated_at,
            'updated_by' => $entity->updated_by,
        ];

        /** @var MiscModel $this */
        if (request()->get('related', false)) {
            $data['attributes'] = AttributeResource::collection($this->attributes);
            $data['entity_notes'] = EntityNoteResource::collection($this->notes);
            $data['entity_events'] = EntityEventResource::collection($this->events);
            $data['entity_files'] = EntityFileResource::collection($this->files);
            $data['relations'] = RelationResource::collection($this->relationships);
            $data['inventory'] = InventoryResource::collection($this->inventories);
            $data['entity_abilities'] = EntityAbilityResource::collection($this->abilities);
        }

        return $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function entity(array $prepared = [])
    {
        $merged = [
            'id' => $this->id,
            'name' => $this->name,
            'entry' => $this->hasEntry() ? $this->entry : null,
            'entry_parsed' => $this->hasEntry() ? Mentions::map($this->resource) : null,
            'image' => $this->image,
            'image_full' => $this->getImageUrl(),
            'image_thumb' => $this->getImageUrl(40),
            'has_custom_image' => !empty($this->image),

            'is_private' => (bool) $this->is_private,
            'entity_id' => $this->entity->id,
            'tags' => $this->entity->tags()->pluck('tags.id')->toArray(),

            'created_at' => $this->created_at,
            'created_by' => $this->entity->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->entity->updated_by,
        ];

        // Foreign elements
        $attributes = $this->getAttributes();
        if (array_key_exists('location_id', $attributes)) {
            $merged['location_id'] = $this->location_id;
        }
        if (array_key_exists('character_id', $attributes)) {
            $merged['character_id'] = $this->character_id;
        }

        /** @var MiscModel $this */
        if (request()->get('related', false) || $this->withRelated) {
            $merged['attributes'] = AttributeResource::collection($this->entity->attributes);
            $merged['entity_notes'] = EntityNoteResource::collection($this->entity->notes);
            $merged['entity_events'] = EntityEventResource::collection($this->entity->events);
            $merged['entity_files'] = EntityFileResource::collection($this->entity->files);
            $merged['relations'] = RelationResource::collection($this->entity->relationships);
            $merged['inventory'] = InventoryResource::collection($this->entity->inventories);
            $merged['entity_abilities'] = EntityAbilityResource::collection($this->entity->abilities);
        }

        $final = array_merge($merged, $prepared);
        //ksort($final);
        return $final;
    }
}
