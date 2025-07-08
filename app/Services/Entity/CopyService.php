<?php

namespace App\Services\Entity;

use App\Models\CharacterRace;
use App\Models\CharacterTrait;
use App\Models\Entity;
use App\Models\MapMarker;
use App\Models\TimelineElement;
use App\Traits\EntityAware;
use App\Traits\RequestAware;
use Illuminate\Support\Facades\DB;

class CopyService
{
    use EntityAware;
    use RequestAware;

    protected Entity $source;

    protected bool $force = false;

    public function source(Entity $entity): self
    {
        $this->source = $entity;

        return $this;
    }

    public function force(): self
    {
        $this->force = true;

        return $this;
    }

    public function fromId(): self
    {
        if (! $this->request->filled('copy_source_id')) {
            return $this;
        }
        $this->source = Entity::find((int) $this->request->get('copy_source_id'));

        return $this;
    }

    public function copy(): void
    {
        // Invalid source, or of a different type?
        if (! isset($this->source) || $this->source->type_id !== $this->entity->type_id) {
            return;
        }

        $this->posts()
            ->links()
            ->abilities()
            ->inventory()
            ->permissions()
            ->reminders()
            ->map()
            ->quest()
            ->timeline();
    }

    public function posts(): self
    {
        if (! $this->force && ! $this->check('copy_posts')) {
            return $this;
        }
        foreach ($this->source->posts()->with(['permissions', 'postTags'])->get() as $post) {
            $post->copyTo($this->entity, $this->isSameCampaign());
        }

        return $this;
    }

    public function attributes(): self
    {
        if (! $this->force && ! $this->check('copy_attributes')) {
            return $this;
        }
        foreach ($this->source->attributes as $attribute) {
            $newAttribute = $attribute->replicate(['entity_id', 'created_by', 'updated_by']);
            $newAttribute->entity_id = $this->entity->id;
            $newAttribute->save();
        }

        return $this;
    }

    protected function links(): self
    {
        if (! $this->force && ! $this->check('copy_links')) {
            return $this;
        }
        foreach ($this->source->assets()->link()->get() as $link) {
            $link->copyTo($this->entity);
        }

        return $this;
    }

    protected function abilities(): self
    {
        if (! $this->force && ! $this->check('copy_abilities')) {
            return $this;
        }
        foreach ($this->source->abilities as $ability) {
            $ability->copyTo($this->entity);
        }

        return $this;
    }

    protected function permissions(): self
    {
        if (! $this->force && ! $this->check('copy_permissions')) {
            return $this;
        }
        foreach ($this->source->permissions as $perm) {
            $perm->copyTo($this->entity);
        }

        return $this;
    }

    public function inventory(): self
    {
        if (! $this->force && ! $this->check('copy_inventory')) {
            return $this;
        }
        foreach ($this->source->inventories as $inventory) {
            $inventory->copyTo($this->entity, $this->isSameCampaign());
        }

        return $this;
    }

    protected function reminders(): self
    {
        if (! $this->force && ! $this->check('copy_reminders')) {
            return $this;
        }
        foreach ($this->source->reminders as $reminder) {
            if ($reminder->isCalendarDate()) {
                continue;
            }
            $reminder->copyTo($this->entity);
        }

        return $this;
    }

    public function character(): self
    {
        if (! $this->source->isCharacter()) {
            return $this;
        }
        /** @var CharacterTrait $trait */
        // @phpstan-ignore-next-line
        foreach ($this->source->child->characterTraits as $trait) {
            $trait->copyTo($this->entity->entity_id);
        }

        // Families, races
        $relations = ['characterFamilies', 'characterRaces', 'organisationMemberships'];
        foreach ($relations as $relation) {
            /** @var CharacterRace $item */
            // @phpstan-ignore-next-line
            foreach ($this->source->child->{$relation} as $item) {
                $new = $item->replicate(['character_id']);
                $new->character_id = $this->entity->entity_id;
                $new->save();
            }
        }

        return $this;
    }

    public function map(): self
    {
        if (! $this->source->isMap() || ! $this->check('copy_elements')) {
            return $this;
        }
        $groups = [];
        // @phpstan-ignore-next-line
        foreach ($this->source->child->layers as $sub) {
            // Old layer not linked to the gallery? Skip it
            if (! empty($sub->image_path)) {
                continue;
            }
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $this->entity->entity_id;

            //            if (!empty($sub->image_path) && Storage::exists($sub->image_path)) {
            //                $uniqid = uniqid();
            //                $newPath = str_replace('.', $uniqid . '.', $sub->image_path);
            //                $newSub->image_path = $newPath;
            //                if (!Storage::exists($newPath)) {
            //                    Storage::copy($sub->image_path, $newPath);
            //                }
            //            }
            $newSub->saveQuietly();
        }
        // @phpstan-ignore-next-line
        foreach ($this->source->child->groups as $sub) {
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $this->entity->entity_id;
            $newSub->saveQuietly();
            $groups[$sub->id] = $newSub->id;
        }
        // @phpstan-ignore-next-line
        foreach ($this->source->child->markers as $sub) {
            /** @var MapMarker $newSub */
            $newSub = $sub->replicate(['map_id']);
            $newSub->map_id = $this->entity->entity_id;
            $newSub->group_id = ! empty($newSub->group_id) && isset($groups[$newSub->group_id]) ? $groups[$newSub->group_id] : null;

            // If moving to another campaign, switch the markers pointing to an entity
            if (! empty($newSub->entity_id) && ! $this->isSameCampaign()) {
                $newSub->entity_id = null;
                if ($newSub->icon == 4) {
                    $newSub->icon = 1;
                }
                if (empty($newSub->name)) {
                    // Because the permission engine is already set on the new campaign, searching the marker's entity
                    // will always fail. So we need to go get it directly
                    $raw = DB::table('entities')
                        ->select('name')
                        ->where('id', $sub->entity_id)
                        ->first();
                    $newSub->name = $raw ? $raw->name : 'Copy of #' . $sub->id;
                }
            }
            $newSub->saveQuietly();
        }

        return $this;
    }

    protected function quest(): self
    {
        if (! $this->source->isQuest() || ! $this->check('copy_elements')) {
            return $this;
        }
        // @phpstan-ignore-next-line
        foreach ($this->source->child->elements as $sub) {
            $newSub = $sub->replicate();
            $newSub->quest_id = $this->entity->entity_id;
            $newSub->save();
        }

        return $this;
    }

    public function timeline(): self
    {
        if (! $this->source->isTimeline() || (! $this->force && ! $this->check('copy_eras'))) {
            return $this;
        }
        $copyElements = $this->force || $this->check('copy_elements');
        // @phpstan-ignore-next-line
        foreach ($this->source->child->eras()->with('elements')->get() as $era) {
            $newEra = $era->replicate();
            $newEra->timeline_id = $this->entity->entity_id;
            $newEra->save();

            if (! $copyElements) {
                continue;
            }
            foreach ($era->elements as $element) {
                /** @var TimelineElement $newElement */
                $newElement = $element->replicate();
                $newElement->timeline_id = $this->entity->entity_id;
                $newElement->era_id = $newEra->id;
                if (! $this->isSameCampaign()) {
                    $newElement->entity_id = null;
                    if (empty($newElement->name)) {
                        continue;
                    }
                }
                $newElement->save();
            }
        }

        return $this;
    }

    protected function check(string $field): bool
    {
        return isset($this->request) && $this->request->has($field) && $this->request->filled($field);
    }

    protected function isSameCampaign(): bool
    {
        return $this->source->campaign_id === $this->entity->campaign_id;
    }
}
