<?php

namespace App\Http\Resources;

use App\Facades\CampaignLocalization;
use App\Facades\Img;
use App\Facades\Mentions;
use App\Models\MiscModel;
use App\Services\Api\ApiService;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class EntityResource extends JsonResource
{
    use ApiSync;

    /** @var bool If the entity should come with related objects */
    public $withRelated = false;

    /** @var bool If the entity comes with the misc model */
    public $withMisc = false;

    /**
     * Get related objects for this entity
     * @return $this
     */
    public function withRelated(): self
    {
        $this->withRelated = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function withMisc(): self
    {
        $this->withMisc = true;
        return $this;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Entity $entity */
        $entity = $this->resource;

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entity->type,
            'child_id' => $entity->entity_id,
            'tags' => $entity->tags->pluck('id')->toArray(),
            'is_private' => (bool) $entity->is_private,
            'is_template' => (bool) $entity->is_template,
            'campaign_id' => $entity->campaign_id,
            'is_attributes_private' => (bool) $entity->is_attributes_private,
            'tooltip' => $entity->tooltip,
            'header_image' => $entity->header_image,
            'image_uuid' => $entity->image_uuid,

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
            $data['entity_links'] = EntityLinkResource::collection($entity->links);
        }

        if (request()->get('related', false) || request()->get('image', false)) {
            if (!$entity->child) {
                $data['child'] = 'Invalid child, please contact Jay on Discord with the following: EntityResource for #' . $entity->id;
            } else {
                $campaign = CampaignLocalization::getCampaign();
                $image = $campaign->boosted(true) && !empty($entity->image);
                $data['child'] = [
                    'image' => $image ? $entity->image->path : $entity->child->image,
                    'image_full' => $image ? Img::resetCrop()->url($entity->image->path) : $entity->avatar(),
                    'image_thumb' => $image ? Img::crop(40, 40)->url($entity->image->path) : $entity->avatar(true),
                    'has_custom_image' => $image || !empty($entity->child->image)
                ];
            }
        }

        // Get the actual model
        if ($this->withMisc) {
            $className = 'App\Http\Resources\\' . ucfirst($entity->type) . 'Resource';
            if (class_exists($className)) {
                $obj = new $className($entity->child);
                $data['child'] = $obj;
            } else {
                $data['child'] = 'unknown child class ' . $className;
            }
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
        /** @var MiscModel $misc */
        $misc = $this->resource;

        $galleryImage = $misc->entity->image;
        $campaign = CampaignLocalization::getCampaign();
        $superboosted = $campaign->boosted(true);

        $merged = [
            'id' => $misc->id,
            'name' => $misc->name,
            'entry' => $this->hasEntry() ? $misc->entry : null,
            'entry_parsed' => $misc->hasEntry() ? Mentions::map($this->resource) : null,
            'image' => $misc->image,
            'focus_x' => $misc->entity->focus_x,
            'focus_y' => $misc->entity->focus_y,

            // Image
            'image_full' => !empty($misc->image) ? $misc->getImageUrl(0) : ($misc->entity->image ? $misc->entity->image->getImagePath(0) : null),
            'image_thumb' => $misc->getImageUrl(40),
            'has_custom_image' => !empty($misc->image) || !empty($galleryImage),

            // Header
            'header_full' => $misc->entity->getHeaderUrl($superboosted),
            'has_custom_header' => $misc->entity->hasHeaderImage($superboosted),

            'is_private' => (bool) $this->is_private,
            'is_template' => (bool) $this->entity->is_template,

            'entity_id' => $this->entity->id,
            'tags' => $this->entity->tags()->pluck('tags.id')->toArray(),


            'created_at' => $misc->created_at,
            'created_by' => $misc->entity->created_by,
            'updated_at' => $misc->updated_at,
            'updated_by' => $misc->entity->updated_by,
        ];

        // Foreign elements
        $attributes = $misc->getAttributes();
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
            $merged['entity_links'] = EntityLinkResource::collection($this->entity->links);
        }

        $final = array_merge($merged, $prepared);
        //ksort($final);
        return $final;
    }
}
