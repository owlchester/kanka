<?php

namespace App\Services\Entity;

use App\Facades\Avatar;
use App\Facades\Module;
use App\Models\Attribute;
use App\Models\Character;
use App\Models\Location;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class PreviewService
{
    use CampaignAware;
    use EntityAware;

    protected array $profile = [];

    protected array $data = [];

    public function preview(): array
    {
        $this->data = [
            'id' => $this->entity->id,
            'name' => $this->entity->name,
            // @phpstan-ignore-next-line
            'title' => $this->entity->isCharacter() ? $this->entity->child?->title : null,
            'link' => $this->entity->url(),
            'image' => $this->image(),
        ];

        $this->data['is_dead'] = false;
        $this->data['tags'] = $this->tags();
        $this->data['location'] = $this->location();
        $this->data['attributes'] = $this->attributes();
        $this->data['profile'] = $this->profile();
        $this->data['connections'] = $this->connections();
        $this->data['access'] = []; // $this->access();

        $this->data['texts'] = [
            'profile' => __('crud.tabs.profile'),
            'connections' => __('search.preview.links'),
            'no-connections' => __('search.preview.no-connections'),
        ];

        return $this->data;
    }

    /**
     * Load specific stuff from the child for the profile
     */
    protected function profile(): array
    {
        if ($this->entity->entityType->isSpecial()) {
            if (! empty($this->entity->type)) {
                $this->addProfile('crud.fields.type', 'type', $this->entity->type);
            }
        } else {
            /** @var MiscModel|Character $child */
            $child = $this->entity->child;
            if (! empty($this->entity->type)) {
                $this->addProfile('crud.fields.type', 'type', $this->entity->type);
            }
        }

        // Entity-specific content?
        if ($this->entity->isCharacter() && ! $this->entity->isMissingChild()) {
            /** @var Character $child */
            // @phpstan-ignore-next-line
            $this->characterProfile($child);
        }

        return $this->profile;
    }

    protected function image(): mixed
    {
        return Avatar::entity($this->entity)->size(276)->thumbnail();
    }

    protected function attributes(): array
    {
        $attributes = [];
        /** @var Attribute $attr */
        foreach ($this->entity->starredAttributes() as $attr) {
            if ($attr->isCheckbox()) {
                $val = __('general.no');
                if ($attr->value) {
                    $val = '<i class="fa-solid fa-check" aria-hidden="true"></i>';
                }
                $attributes[] = [
                    'id' => $attr->id,
                    'name' => $attr->name(),
                    'value' => $val,
                ];

                continue;
            }
            $attributes[] = [
                'id' => $attr->id,
                'name' => $attr->name(),
                'value' => $attr->mappedValue(),
            ];
        }

        return $attributes;
    }

    protected function tags(): array
    {
        $tags = [];
        foreach ($this->entity->tags()->with('entity')->get() as $tag) {
            $tags[] = [
                'id' => $tag->id,
                'name' => $tag->name,
                'colour' => $tag->colour,
                'link' => $tag->getLink(),
                'slug' => $tag->slug,
            ];
        }

        return $tags;
    }

    protected function location(): mixed
    {
        if ($this->entity->entityType->isSpecial()) {
            return null;
        }
        /** @var ?Location $loc */
        $loc = null;
        if (method_exists($this->entity->child, 'location') && ! empty($this->entity->child->location)) {
            $loc = $this->entity->child->location;
        }
        if (method_exists($this->entity->child, 'parent_location') && ! empty($this->entity->child->parent_location)) {
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
            if (! $relation->target) {
                continue;
            }
            $rel = [
                'id' => $relation->target->id,
                'name' => $relation->target->name,
                'type' => $relation->relation,
                'image' => Avatar::entity($relation->target)->size(64)->thumbnail(),
                'link' => $relation->target->url(),
            ];

            $relations[] = $rel;
        }

        return $relations;
    }

    protected function characterProfile(Character $child): void
    {
        if ($child->characterFamilies->isNotEmpty()) {
            $races = $child->characterFamilies->pluck('family.name')->toArray();
            $key = Module::plural(config('entities.ids.family'), 'entities.families');
            $this->addProfile($key, 'families', implode(', ', $races));
        }

        if ($child->characterRaces->isNotEmpty()) {
            $races = $child->characterRaces->pluck('race.name')->toArray();
            $key = Module::plural(config('entities.ids.race'), 'entities.races');
            $this->addProfile($key, 'races', implode(', ', $races));
        }

        if ($child->age) {
            $this->addProfile('characters.fields.age', 'age', $child->age);
        }

        if ($child->sex) {
            $this->addProfile('characters.fields.sex', 'gender', $child->sex);
        }

        if ($child->pronouns) {
            $this->addProfile('characters.fields.pronouns', 'pronouns', $child->pronouns);
        }

        if ($child->is_dead) {
            $this->data['is_dead'] = true;
        }
    }

    protected function addProfile(string $key, string $slug, mixed $value = null): void
    {
        $this->profile[] = [
            'field' => __($key),
            'slug' => $slug,
            'value' => $value,
        ];
    }
}
