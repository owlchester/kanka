<?php

namespace App\Services\Entity;

use App\Facades\Img;
use App\Models\Attribute;
use App\Models\Location;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class PreviewService
{
    use EntityAware;
    use CampaignAware;

    public function preview(): array
    {
        $data = [
            'id' => $this->entity->id,
            'name' => $this->entity->name,
            'title' => $this->entity->isCharacter() ? $this->entity->child->title : null,
            'link' => $this->entity->url(),
            'image' => $this->image()
        ];

        $data['tags'] = $this->tags();
        $data['location'] = $this->location();
        $data['attributes'] = $this->attributes();
        $data['profile'] = $this->profile();
        $data['connections'] = $this->connections();
        $data['access'] = []; //$this->access();

        return $data;
    }

    /**
     * Load specific stuff from the child for the profile
     * @return array
     */
    protected function profile(): array
    {
        $profile = [];
        /** @var MiscModel $child */
        $child = $this->entity->child;
        if (!empty($child->type)) {
            $profile[] = [
                'field' => __('crud.fields.type'),
                'slug' => 'type',
                'value' => $child->type,
            ];
        }

        // Entity-specific content?


        return $profile;
    }

    protected function image(): mixed
    {
        if ($this->entity->child->image) {
            return $this->entity->child->thumbnail(250);
        } elseif ($this->campaign->superboosted() && $this->entity->image) {
            return Img::crop(250, 250)->url($this->entity->image->path);
        }
        return null;
    }

    protected function attributes(): array
    {
        $attributes = [];
        /** @var Attribute $attr */
        foreach($this->entity->starredAttributes() as $attr) {
            if ($attr->isCheckbox()) {
                $val = __('general.no');
                if ($attr->value) {
                    $val = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
                }
                $attributes[] = [
                    'name' => $attr->name(),
                    'value' => $val,
                ];
                continue;
            }
            $attributes[] = [
                'name' => $attr->name(),
                'value' => $attr->mappedValue()
            ];
        }

        return $attributes;
    }

    protected function tags(): array
    {
        $tags = [];
        foreach ($this->entity->tags as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'colour' => $tag->colour,
                'link' => $tag->getLink(),
            ];
        }

        return $tags;
    }
    protected function location(): mixed
    {
        /** @var ?Location $loc */
        $loc = null;
        if (method_exists($this->entity->child, 'location') && !empty($this->entity->child->location)) {
            $loc = $this->entity->child->location;
        }
        if (method_exists($this->entity->child, 'parent_location') && !empty($this->entity->child->parent_location)) {
            $loc = $this->entity->child->parent_location;
        }

        if (empty($loc)) {
            return null;
        }
        return [
            'name' => $loc->name,
            'link' => $loc->getLink(),
        ];
    }

    protected function connections(): array
    {
        $relations = [];

        foreach ($this->entity->pinnedRelations as $relation) {
            if (!$relation->target) {
                continue;
            }
            $rel = [
                'id' => $relation->target->id,
                'name' => $relation->target->name,
                'type' => $relation->relation,
                'image' => $relation->target->avatar(),
                'link' => $relation->target->url(),
            ];

            $relations[] = $rel;
        }

        return $relations;
    }
}
