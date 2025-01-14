<?php

namespace App\Services;

use App\Models\EntityType;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class EntityTypeService
{
    use CampaignAware;
    use EntityTypeAware;

    protected array $exclude = [];
    protected array $append;
    protected bool $withDisabled = false;

    public function exclude(mixed $ids): self
    {
        $this->exclude = is_array($ids) ? $ids : [$ids];
        return $this;
    }

    public function withDisabled(): self
    {
        $this->withDisabled = true;
        return $this;
    }

    public function append(array $append): self
    {
        $this->append = $append;
        return $this;
    }

    public function ordered(): array
    {
        $types = [];

        $search = EntityType::inCampaign($this->campaign)->exclude($this->exclude);
        if (!$this->withDisabled) {
            $search->enabled();
        }
        foreach ($search->get() as $entityType) {
            $types[$entityType->name()] = $entityType;
        }

        $collator = new \Collator(app()->getLocale());
        usort($types, function ($a, $b) use ($collator) {
            return $collator->compare($a->name(), $b->name());
        });

        return $types;
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

    public function save(array $data): void
    {
        if (!isset($this->entityType)) {
            $this->entityType = new EntityType();
            $this->entityType->campaign_id = $this->campaign->id;
            $this->entityType->is_special = 1;
            $this->entityType->is_enabled = 1;
            $this->entityType->code = Str::slug(Arr::get($data, 'singular'));
        }

        $this->entityType->singular = Arr::get($data, 'singular');
        $this->entityType->plural = Arr::get($data, 'plural');
        $this->entityType->icon = Arr::get($data, 'icon');
        $this->entityType->save();
    }

    public function toggle(): void
    {
        $this->entityType->is_enabled = !$this->entityType->is_enabled;
        $this->entityType->save();
    }
}
