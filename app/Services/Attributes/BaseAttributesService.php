<?php

namespace App\Services\Attributes;

use App\Models\Attribute;
use App\Traits\EntityAware;

abstract class BaseAttributesService
{
    use EntityAware;

    protected Attribute $attribute;

    protected array $purifyConfig;

    protected array $existing = [];

    protected int $order = 0;

    protected bool $touched = false;

    /**
     * When we're done updating the attributes, if anything was changed, we need to "touch" the entity to have a log and
     * updated timestamp.
     */
    public function touch(): self
    {
        if (! $this->touched) {
            return $this;
        }
        $this->entity->touch();

        return $this;
    }

    /**
     * Prepare a custom HTML purifying config for attributes. We remove all custom fields that are added to purify.php
     * and in PurifySetupProvider.
     */
    protected function purifyConfig(): self
    {
        $purifyConfig = config('purify.configs.default');
        $purifyConfig['HTML.Allowed'] = preg_replace('`,a\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,iframe\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,summary\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,table\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,details\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figure\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);
        $purifyConfig['HTML.Allowed'] = preg_replace('`,figcaption\[(.*?)\]`', '$2', $purifyConfig['HTML.Allowed']);

        $this->purifyConfig = $purifyConfig;

        return $this;
    }
}
