<?php

namespace App\Services\Entity;

use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Support\Str;

class TooltipService
{
    use CampaignAware;
    use EntityAware;

    /**
     * Full tooltip used for ajax calls
     */
    public function tooltip(): string
    {
        if ($this->entity->isMissingChild()) {
            return '';
        }

        $limit = 500;
        if ($this->campaign->boosted()) {
            $limit = 1000;
            // If the campaign is boosted, entities can have a custom tooltip. This allows them to use some
            // html syntax, and thus a lot more control on what is displayed.
            $boostedTooltip = strip_tags($this->entity->tooltip);
            if (! empty(mb_trim($boostedTooltip))) {
                $text = $this->entity->parsedEntry();
                $text = strip_tags($text, $this->allowedTooltipTags());
                if (! empty($text)) {
                    return nl2br($text);
                }
            }
        }

        if (! method_exists($this->entity, 'parsedEntry')) {
            return '';
        }
        $text = $this->entity->parsedEntry();
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
