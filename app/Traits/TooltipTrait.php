<?php

namespace App\Traits;

trait TooltipTrait
{
    /**
     * Get the entity link with ajax tooltip
     * @param string $name override the name of the entity
     * @return string
     */
    public function tooltipedLink(string $name = null): string
    {
        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->id . '"' .
            'data-url="' . route('entities.tooltip', $this->id). '" href="' . $this->url() . '">' .
            e(!empty($name) ? $name : $this->name) .
            '</a>';
    }
}
