<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use App\Models\Entity;
use App\Models\MiscModel;
use Illuminate\Support\Str;

trait HasTooltip
{
    /**
     * Full tooltip used for ajax calls
     */
    public function ajaxTooltip(): string
    {
        if ($this->isMissingChild()) {
            return '';
        }

        $text = null;

        $campaign = CampaignLocalization::getCampaign();
        if ($campaign->boosted()) {
            // If the campaign is boosted, entities can have a custom tooltip. This allows them to use some
            // html syntax, and thus a lot more control on what is displayed.
            $boostedTooltip = strip_tags($this->tooltip);
            if (!empty(mb_trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                $text = strip_tags($text, $this->allowedTooltipTags());
                if (!empty($text)) {
                    return nl2br($text);
                }
            }
        }

        $child = $this;
        if ($this->hasChild()) {
            $child = $this->child;
        }
        if (!method_exists($child, 'parsedEntry')) {
            return '';
        }
        $text = $child->parsedEntry();
        $text = strip_tags($text, $this->allowedTooltipTags());
        $text = Str::limit($text, 500);
        return $text;
    }

    /**
     * Allowed tags in tooltips, allowing Salvatos to do some interesting things with css
     */
    protected function allowedTooltipTags(): array
    {
        $html = [];
        foreach (config('purify.configs.tooltips.allowed') as $tag) {
            $html[] = "<{$tag}>";
        }
        $html[] = '<br>';
        return $html;
    }
}
