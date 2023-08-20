<?php

namespace App\Services\Entity;

use App\Facades\Module;
use App\Models\MiscModel;
use App\Traits\CampaignAware;
use Illuminate\Support\Str;

class TypeService
{
    use CampaignAware;

    protected array $exclude = [];

    protected bool $plural = false;
    protected bool $withNull = false;

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

    public function labelled(): array
    {
        $labels = [];
        if ($this->withNull) {
            $labels = ['' => ''];
        }

        $entities = config('entities.classes');
        foreach ($entities as $entity => $class) {
            if (!auth()->user()->can('create', $class)) {
                continue;
            }
            /** @var MiscModel|mixed $misc */
            if ($this->plural) {
                $entity = Str::plural($entity);
            }
            $misc = new $class();
            if ($this->plural) {
                $labels[$entity] = Module::plural($misc->entityTypeId(), __('entities.' . $entity));
            } else {
                $labels[$entity] = Module::singular($misc->entityTypeId(), __('entities.' . $entity));
            }
        }

        if (empty($this->exclude)) {
            return $labels;
        }
        foreach ($this->exclude as $unset) {
            unset($labels[$unset]);
        }

        return $labels;
    }
}
