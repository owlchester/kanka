<?php

namespace App\Http\Resources;

use App\Facades\Avatar;
use App\Facades\Mentions;
use App\Models\Item;
use App\Models\MiscModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class EntityResource extends JsonResource
{
    use ApiSync;

    /** @var bool If the entity should come with related objects */
    public bool $withRelated = false;

    /** @var bool If the entity comes with the misc model */
    public bool $withMisc = false;

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
        $url = $entity->url();
        if ($entity->entityType->isSpecial()) {
            $apiViewUrl = 'campaigns.entities.show';
        } else {
            $apiViewUrl = 'campaigns.' . $entity->entityType->pluralCode() . '.show';
        }

        $data = [
            'id' => $entity->id,
            'name' => $entity->name,
            'type' => $entity->entityType->code,
            'type_field' => $entity->type,
            'type_id' => $entity->type_id,
            'module' => [
                'id' => $entity->entityType->id,
                'code' => $entity->entityType->code,
                'singular' => $entity->entityType->name(),
                'plural' => $entity->entityType->plural(),
            ],
            'tags' => $entity->tags->pluck('id')->toArray(),
            'is_private' => (bool) $entity->is_private,
            'is_template' => $entity->isTemplate(),
            'campaign_id' => $entity->campaign_id,
            'is_attributes_private' => (bool) $entity->is_attributes_private,
            'tooltip' => $entity->tooltip,
            'header_image' => $entity->header_image,
            'header_uuid' => $entity->header_uuid,
            'image_uuid' => $entity->image_uuid,

            'created_at' => $entity->created_at,
            'created_by' => $entity->created_by,
            'updated_at' => $entity->updated_at,
            'updated_by' => $entity->updated_by,

            'urls' => [
                'view' => $url,
                'api' => Route::has($apiViewUrl) ? route($apiViewUrl, [$entity->campaign_id, $entity->entity_id]) : null,
            ]
        ];

        if ($entity->entityType->isSpecial()) {
            $data['entry'] = $entity->entry;
            $data['entry_parsed'] = Mentions::mapEntity($entity, 'entry');
            $data['parent_id'] = $entity->parent_id;
        } else {
            $data['child_id'] = $entity->entity_id;
        }

        if (request()->get('related', false)) {
            $data['attributes'] = AttributeResource::collection($entity->attributes);
            $data['posts'] = PostResource::collection($entity->posts);
            $data['entity_events'] = EntityEventResource::collection($entity->reminders);
            $data['relations'] = RelationResource::collection($entity->relationships);
            $data['inventory'] = InventoryResource::collection($entity->inventories);
            $data['entity_abilities'] = EntityAbilityResource::collection($entity->abilities);
        }

        if (request()->get('related', false) || request()->get('image', false)) {
            if ($entity->isMissingChild()) {
                $data['child'] = 'Invalid child, please contact us on Discord with the following: EntityResource for #' . $entity->id;
            } else {
                $image = !empty($entity->image);
                $data['child'] = [
                    'image' => $image ? $entity->image->path : $entity->image_path,
                    'image_full' => Avatar::entity($entity)->original(),
                    'image_thumb' => Avatar::entity($entity)->size(40)->thumbnail(),
                    'has_custom_image' => $image || !empty($entity->image_path),
                ];
            }
        }

        // Get the actual model
        if ($this->withMisc) {
            $className = 'App\Http\Resources\\' . ucfirst($entity->entityType->code) . 'Resource';
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
     * @return array|string
     */
    public function entity(array $prepared = [])
    {
        /** @var mixed|MiscModel|Item $misc */
        $misc = $this->resource;
        if (!$misc->entity) {
            return 'permission issue';
        }

        $galleryImage = $misc->entity->image;
        $url = $misc->getLink();
        $apiViewUrl = 'campaigns.' . $misc->entity->entityType->pluralCode() . '.show';

        $merged = [
            'id' => $misc->id,
            'name' => $misc->name,
            'entry' => $misc->entity->hasEntry() ? $misc->entity->entry : null,
            'entry_parsed' => $misc->entity->hasEntry() ? Mentions::mapAny($misc->entity) : null,
            'tooltip' => $misc->entity->tooltip ?: null,
            'type' => $misc->entity->type ?: null,
            'image' => $misc->entity->image_path,
            'focus_x' => $misc->entity->focus_x,
            'focus_y' => $misc->entity->focus_y,

            // Image
            'image_full' => Avatar::entity($misc->entity)->original(),
            'image_thumb' => Avatar::size(40)->fallback()->thumbnail(),
            'has_custom_image' => !empty($misc->entity->image_path) || !empty($galleryImage),
            'image_uuid' => $misc->entity->image ? $misc->entity->image->id : null,

            // Header
            'header_full' => $misc->entity->getHeaderUrl(),
            'header_uuid' => $misc->entity->header ? $misc->entity->header->id : null,
            'has_custom_header' => $misc->entity->hasHeaderImage(),

            'is_private' => (bool) $misc->is_private,
            'is_template' => (bool) $misc->entity->isTemplate(),

            'is_attributes_private' => (bool) $misc->entity->is_attributes_private,

            'entity_id' => $misc->entity->id,

            //            'module' => [
            //                'id' => $misc->entity->entityType->id,
            //                'code' => $misc->entity->entityType->code,
            //                'singular' => $misc->entity->entityType->name(),
            //                'plural' => $misc->entity->entityType->plural(),
            //            ],
            'tags' => $misc->entity->tags()->pluck('tags.id')->toArray(),

            'created_at' => $misc->created_at,
            'created_by' => $misc->entity->created_by,
            'updated_at' => $misc->updated_at,
            'updated_by' => $misc->entity->updated_by,

            'urls' => [
                'view' => $url,
                'api' => Route::has($apiViewUrl) ? route($apiViewUrl, [$misc->campaign_id, $misc->id]) : null,
            ]
        ];

        // Foreign elements
        $attributes = $misc->getAttributes();
        if (array_key_exists('location_id', $attributes)) {
            $merged['location_id'] = $misc->location_id;
        }
        if (array_key_exists('character_id', $attributes)) {
            $merged['character_id'] = $misc->character_id;
        }

        if (request()->get('related', false) || $this->withRelated) {
            $merged['attributes'] = AttributeResource::collection($misc->entity->attributes);
            $merged['posts'] = PostResource::collection($misc->entity->posts);
            $merged['entity_events'] = EntityEventResource::collection($misc->entity->reminders);
            $merged['relations'] = RelationResource::collection($misc->entity->relationships);
            $merged['inventory'] = InventoryResource::collection($misc->entity->inventories);
            $merged['entity_abilities'] = EntityAbilityResource::collection($misc->entity->abilities);
            $merged['entity_assets'] = EntityAssetResource::collection($misc->entity->assets);

            if ($misc->ancestors) {
                $ancestors = [];
                foreach ($misc->ancestors as $ancestor) {
                    $ancestors[] = $ancestor->id;
                }
                $merged['parents'] = $ancestors;
            }
            if ($misc->children) {
                $descendants = [];
                foreach ($misc->children as $descendant) {
                    $descendants[] = $descendant->id;
                }
                $merged['children'] = $descendants;
            }
        }

        $final = array_merge($merged, $prepared);
        //ksort($final);
        return $final;
    }

}
