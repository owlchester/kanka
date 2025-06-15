<?php

namespace App\Traits;

use App\Facades\CampaignLocalization;
use App\Facades\Mentions;
use Illuminate\Support\Str;

trait HasTooltip
{
    /**
     * Full tooltip used for ajax calls
     */
    public function ajaxTooltip(): string
    {
        $text = null;

        $campaign = CampaignLocalization::getCampaign();
        $limit = 500;
        if ($campaign->boosted()) {
            $limit = 1000;
            // If the campaign is boosted, entities can have a custom tooltip. This allows them to use some
            // html syntax, and thus a lot more control on what is displayed.
            $boostedTooltip = strip_tags($this->tooltip);
            if (! empty(mb_trim($boostedTooltip))) {
                $text = Mentions::mapEntity($this);
                $text = strip_tags($text, $this->allowedTooltipTags());
                if (! empty($text)) {
                    return '<div>' . nl2br($text) . '<div>';
                }
            }
        }

        if (! method_exists($this, 'parsedEntry')) {
            return '';
        }
        $text = $this->parsedEntry();
        $text = strip_tags($text, $this->allowedTooltipTags());
        $text = $this->limitTooltipTextLength($text, $limit);

        return $text;
    }

    protected function limitTooltipTextLength(string $text, int $limit): string
    {
        // Extract links to exclude them from the character count
        $links = [];
        preg_match_all('/<a[^>]*>(.*?)<\/a>/is', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $index => $match) {
            // Temporarily replace link with placeholder
            $placeholder = "___LINK_{$index}___";
            $text = Str::replace($match[0], $placeholder, $text);
            $links[$placeholder] = $match[0];
        }

        // Limit text length excluding link placeholders
        $text = Str::limit($text, $limit);

        // Restore links from placeholders
        foreach ($links as $placeholder => $link) {
            $text = Str::replace($placeholder, $link, $text);
        }

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
