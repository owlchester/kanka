<?php

namespace App\Traits;

trait TooltipTrait
{
    /**
     * Get the entity link with ajax tooltip
     * @return string
     */
    public function tooltipedLink(string $attribute = 'a'): string
    {
        return '<' . $attribute . ' class="name" data-toggle="tooltip-ajax" data-id="' . $this->id . '"' .
            'data-url="' . route('entities.tooltip', $this->id). '" href="' . $this->url() . '">' .
            e($this->name) .
            "</$attribute>";
    }
}
