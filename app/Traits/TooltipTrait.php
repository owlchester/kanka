<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use App\Models\MiscModel;
use Illuminate\Support\Str;

trait TooltipTrait
{
    /**
     * Get the entity link with ajax tooltip
     * @param null|string $name override the name of the entity
     * @param bool $escape if the passed name should be escape (security)
     * @param null|string $data data attributes to control the placement of the tooltip
     * @return string
     */
    public function tooltipedLink(string $name = null, bool $escape = true, string $data = null): string
    {
        $displayName = !empty($name) ? ($escape ? e($name) : $name) : e($this->name);
        return '<a class="name" data-toggle="tooltip-ajax" data-id="' . $this->id . '"' .
            'data-url="' . route('entities.tooltip', $this->id). '" href="' . $this->url() . '" ' . $data . '>' .
            $displayName .
            '</a>';
    }

    /**
     * Full tooltip used for ajax calls
     * @return string
     */
    public function ajaxTooltip(): string
    {
        if (empty($this->child)) {
            return '';
        }

        $text = null;

        $campaign = CampaignLocalization::getCampaign();
        if ($campaign->boosted()) {
            // If the campaign is boosted, entities can have a custom tooltip. This allows them to use some
            // html syntax, and thus a lot more control on what is displayed.
            $boostedTooltip = strip_tags($this->tooltip);
            if (!empty(trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                $text = strip_tags($text, $this->allowedTooltipTags());
                if (!empty($text)) {
                    return nl2br($text);
                }
            }
        }

        /** @var MiscModel $child */
        $child = $this->child;
        $text = $child->entry();
        $text = strip_tags($text, $this->allowedTooltipTags());
        $text = Str::limit($text, 500);
        return $text;
    }

    /**
     * Allowed tags in tooltips, allowing Salvatos to do some interesting things with css
     * @return array
     */
    protected function allowedTooltipTags(): array
    {
        $html = [];
        foreach (config('purify.tooltips.allowed') as $tag) {
            $html[] = "<$tag>";
        }
        $html[] = '<br>';
        return $html;
    }
}
