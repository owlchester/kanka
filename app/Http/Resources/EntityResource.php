<?php

namespace App\Http\Resources;

use App\Models\MiscModel;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
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
            'entry' => $this->entry,
            'image' => $this->image,
            'image_full' => $this->getImageUrl(),
            'image_thumb' => $this->getImageUrl(true),
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
        if (request()->get('related', false)) {
            $merged['attributes'] = new AttributeCollection($this->entity->attributes);
            $merged['entity_notes'] = new AttributeCollection($this->entity->notes);
            $merged['entity_events'] = new AttributeCollection($this->entity->events);
            $merged['entity_files'] = new EntityFileCollection($this->entity->files);
            $merged['relations'] = new RelationCollection($this->entity->relationships);
            $merged['inventory'] = new RelationCollection($this->entity->inventories);
        }

        $final = array_merge($merged, $prepared);
        //ksort($final);
        return $final;
    }
}
