<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\CampaignPermission;
use App\Models\CampaignRole;
use App\Models\EntityType;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class EntityTypeService
{
    use CampaignAware;
    use EntityTypeAware;
    use RequestAware;
    use UserAware;

    protected array $exclude = [];
    protected array $skip = [];
    protected array $prepend;
    protected bool $withDisabled = false;
    protected bool $creatable = false;

    public function exclude(mixed $ids): self
    {
        $this->exclude = is_array($ids) ? $ids : [$ids];
        return $this;
    }

    public function skip(mixed $skip): self
    {
        $this->skip = is_array($skip) ? $skip : [$skip];
        return $this;
    }

    public function withDisabled(): self
    {
        $this->withDisabled = true;
        return $this;
    }

    public function prepend(array $prepend): self
    {
        $this->prepend = $prepend;
        return $this;
    }

    public function available(): Collection
    {
        $types = new Collection();

        $search = EntityType::inCampaign($this->campaign)->exclude($this->exclude);
        if (!$this->withDisabled) {
            $search->enabled();
        }
        /** @var EntityType $entityType */
        foreach ($search->get() as $entityType) {
            if (in_array($entityType->pluralCode(), $this->skip)) {
                continue;
            }
            // Skip disabled standard modules
            if (!$this->withDisabled && !$entityType->isSpecial() && !$this->campaign->enabled($entityType)) {
                continue;
            }
            if ($this->creatable && !$this->user->can('create', [$entityType, $this->campaign])) {
                continue;
            }
            $types->add($entityType);
        }

        return $types;
    }

    public function creatable(): self
    {
        $this->creatable = true;
        return $this;
    }


    public function ordered(): Collection
    {
        return $this->available()->sortBy(fn (EntityType $a) => $a->name());
        //
        //        $collator = new \Collator(app()->getLocale());
        //        usort($types, function ($a, $b) use ($collator) {
        //            return $collator->compare($a->name(), $b->name());
        //        });
        //
        //        return $types;
    }

    public function toSelect(): array
    {
        $options = $this->ordered();
        $values = [];
        foreach ($options as $entityType) {
            $values[$entityType->id] = $entityType->plural();
        }

        if (!isset($this->prepend)) {
            return $values;
        }
        return $this->prepend + $values;
    }

    public function save(): EntityType
    {
        if (!isset($this->entityType)) {
            $this->entityType = new EntityType();
            $this->entityType->campaign_id = $this->campaign->id;
            $this->entityType->is_special = true;
            $this->entityType->is_enabled = true;
            $this->entityType->code = Str::slug($this->request->get('singular'));
        }

        $this->entityType->singular = $this->request->get('singular');
        $this->entityType->plural = $this->request->get('plural');
        $this->entityType->icon = $this->request->get('icon');
        $this->entityType->save();

        if ($this->entityType->wasRecentlyCreated) {
            $this->permissions()->bookmark();
        }

        return $this->entityType;
    }

    public function toggle(): void
    {
        $this->entityType->is_enabled = !$this->entityType->is_enabled;
        $this->entityType->save();
    }

    protected function bookmark(): self
    {
        $bookmark = new Bookmark();
        $bookmark->campaign_id = $this->campaign->id;
        $bookmark->entity_type_id = $this->entityType->id;
        $bookmark->name = $this->entityType->singular;
        $bookmark->save();
        return $this;
    }

    protected function permissions(): self
    {
        if (!$this->request->has('role')) {
            return $this;
        }

        foreach ($this->request->get('role') as $roleID) {
            /** @var CampaignRole $campaignRole */
            $campaignRole = $this->campaign->roles->where('id', $roleID)->first();
            if (!$campaignRole || $campaignRole->isAdmin()) {
                continue;
            }

            $perm = new CampaignPermission();
            $perm->entity_type_id = $this->entityType->id;
            $perm->campaign_id = $this->campaign->id;
            $perm->campaign_role_id = $campaignRole->id;
            $perm->access = 1;
            $perm->save();
        }
        return $this;
    }

    public function delete()
    {
        $this->entityType->bookmarks()->delete();
        $this->entityType->entities()->delete();
        $this->entityType->attributeTemplates()->delete();
        $this->entityType->entities()->delete();
    }
}
