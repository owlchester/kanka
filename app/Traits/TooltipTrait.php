<?php

namespace App\Traits;

trait TooltipTrait
{
    /**
     * Get the entity link with ajax tooltip
     * @param string $name override the name of the entity
     * @param bool $escape if the passed name should be escape (security)
     * @return string
     */
    public function tooltipedLink(string $name = null, bool $escape = true): string
    {
        $displayName = !empty($name) ? ($escape ? e($name) : $name) : e($this->name);
        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->id . '"' .
            'data-url="' . route('entities.tooltip', $this->id). '" href="' . $this->url() . '">' .
            $displayName .
            '</a>';
    }
}
