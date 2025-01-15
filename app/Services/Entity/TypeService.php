<?php

namespace App\Services\Entity;

use App\Facades\Module;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Collator;

class TypeService
{
    use CampaignAware;

    protected array $exclude = [];
    protected array $add;

    protected bool $plural = false;
    protected bool $alphabetical = true;
    protected bool $withPermission = true;
    protected bool $singularKey = false;

    public function exclude(array $exclude): self
    {
        $this->exclude = $exclude;
        return $this;
    }

    public function add(array $add): self
    {
        $this->add = $add;
        return $this;
    }

    public function plural(): self
    {
        $this->plural = true;
        return $this;
    }

    public function singularKey(): self
    {
        $this->singularKey = true;
        return $this;
    }

    public function permissionless(): self
    {
        $this->withPermission = false;
        return $this;
    }

    public function get(): array
    {
        $labels = [];

        /** @var EntityType[] $entityTypes */
        $entityTypes = EntityType::inCampaign($this->campaign)->enabled()->get();
        foreach ($entityTypes as $entityType) {
            if ($this->withPermission && !auth()->user()->can('create', [$entityType, $this->campaign])) {
                continue;
            }
            if (!$entityType->isSpecial() && !$this->campaign->enabled($entityType->pluralCode())) {
                continue;
            }


        }

        $entities = config('entities.classes');
        foreach ($entities as $entity => $class) {
            if ($this->withPermission && !auth()->user()->can('create', $class)) {
                continue;
            }
            $plural = Str::plural($entity);
            if (!$this->campaign->enabled($plural)) {
                continue;
            }
            if ($this->plural && !$this->singularKey) {
                $entity = $plural;
            }
            /** @var MiscModel|mixed $misc */
            $misc = new $class();
            if ($this->plural) {
                $labels[$entity] = Module::plural($misc->entityTypeId(), __('entities.' . $plural));
            } else {
                $labels[$entity] = Module::singular($misc->entityTypeId(), __('entities.' . $entity));
            }
        }

        $labels = $this->prepare($labels);

        if (empty($this->exclude)) {
            return $labels;
        }
        foreach ($this->exclude as $unset) {
            unset($labels[$unset]);
        }

        if (!isset($this->add)) {
            return $labels;
        }

        return array_merge($this->add, $labels);
    }

    public function prepare(array $labels): array
    {
        if (!$this->alphabetical) {
            return $labels;
        }
        $collator = new Collator(app()->getLocale());
        $collator->asort($labels);
        return $labels;
    }
}
