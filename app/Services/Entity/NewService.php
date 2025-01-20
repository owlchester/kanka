<?php

namespace App\Services\Entity;

use App\Facades\UserCache;
use App\Models\Entity;
use App\Models\EntityType;
use App\Models\Tag;
use App\Observers\PurifiableTrait;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class NewService
{
    use CampaignAware;
    use EntityAware;
    use EntityTypeAware;
    use PurifiableTrait;
    use UserAware;

    protected array $tags;

    protected Collection $available;

    /**
     * Get a list of available entity types the user can create
     * @return Collection|EntityType[]
     */
    public function available(): Collection|array
    {
        if (isset($this->available)) {
            return $this->available;
        }
        $this->available = new Collection();

        if (auth()->guest()) {
            return $this->available;
        }

        $excludedTypes = [
            config('entities.ids.bookmark'),
            config('entities.ids.attribute_template'),
        ];

        foreach ($this->campaign->getEntityTypes() as $entityType) {
            // Skip disabled modules
            if ($entityType->isSpecial() && !$entityType->isEnabled()) {
                continue;
            }
            if (!$entityType->isSpecial() && !$this->campaign->enabled($entityType->pluralCode())) {
                continue;
            }
            if (in_array($entityType->id, $excludedTypes)) {
                continue;
            }
            // Check permission
            if (!auth()->user()->can('create', [$entityType, $this->campaign])) {
                continue;
            }
            $this->available->add($entityType);
        }
        return $this->available;
    }

    public function create(string $name): Entity
    {
        $name = Str::replace(['&lt;', '&gt;'], ['<', '>'], $name);
        if ($this->entityType->isSpecial()) {
            $this->entity = new Entity();
            $this->entity->campaign_id = $this->campaign->id;
            $this->entity->type_id = $this->entityType->id;
            $this->entity->name = $this->purify(mb_trim(strip_tags($name)));
            $this->entity->is_private = $this->private();
            $this->entity->save();
        } else {
            // Todo: we need a better way to handle this in the future
            $misc = $this->entityType->getClass();
            $misc->name = $this->purify(mb_trim(strip_tags($name)));
            $misc->is_private = $this->private();
            $misc->campaign_id = $this->campaign->id;
            $misc->saveQuietly();
            $this->entity = $misc->createEntity();
        }

        if ($this->entity->isTag()) {
            return $this->entity;
        }
        // Apply auto tags to the entity
        $allTags = $this->autoTags();
        $this->entity->tags()->attach($allTags);
        return $this->entity;
    }

    protected function private(): bool
    {
        return (bool) (UserCache::user($this->user)->admin() && $this->campaign->entity_visibility);
    }


    public function autoTags(): array
    {
        if (isset($this->tags)) {
            return $this->tags;
        }
        $this->tags = [];
        $tags = Tag::autoApplied()->has('entity')->get();
        foreach ($tags as $tag) {
            $this->tags[] = $tag->id;
        }

        return $this->tags;
    }
}
