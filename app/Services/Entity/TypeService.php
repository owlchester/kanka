<?php

namespace App\Services\Entity;

use App\Facades\Module;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;
use Collator;

class TypeService
{
    use CampaignAware;

    protected array $exclude = [];

    protected bool $plural = false;
    protected bool $withNull = false;
    protected bool $alphabetical = false;
    protected bool $withPermission = true;
    protected bool $singularKey = false;

    public function exclude(array $exclude): self
    {
        $this->exclude = $exclude;
        return $this;
    }

    public function plural(): self
    {
        $this->plural = true;
        return $this;
    }

    public function withNull(): self
    {
        $this->withNull = true;
        return $this;
    }

    public function singularKey(): self
    {
        $this->singularKey = true;
        return $this;
    }

    public function alphabetical(): self
    {
        $this->alphabetical = true;
        return $this;
    }

    public function permissionless(): self
    {
        $this->withPermission = false;
        return $this;
    }

    public function labelled(): array
    {
        $labels = [];

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

        return $labels;
    }

    public function prepare(array $labels): array
    {
        $prepared = [];
        if ($this->withNull) {
            $prepared = ['' => ''];
        }

        if ($this->alphabetical) {
            $collator = new Collator(app()->getLocale());
            $collator->asort($labels);
        }

        return $prepared + $labels;
    }
}
