<?php

namespace App\Models\Concerns;

use App\Models\Tag;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait Tooltip
{
    /**
     * Wrapper for short entry
     * @return mixed
     */
    public function tooltip($limit = 250, $stripSpecial = true)
    {
        // Replace return chars to space to avoid "text blabla.New sentence"
        $pureHistory = str_replace('<br />', " ", $this->{$this->tooltipField});

        // Always remove tags. ALWAYS.
        $pureHistory = strip_tags($pureHistory);

        if ($stripSpecial) {
            // Remove double quotes because they are the spawn of the devil.
            $pureHistory = str_replace('"', '\'', $pureHistory);
            $pureHistory = str_replace('&quot;', '\'', $pureHistory);

            // Remove any leftover < and > for sanity's sake
            $pureHistory = str_replace('&gt;', null, $pureHistory);
            $pureHistory = str_replace('&lt;', null, $pureHistory);
            //$pureHistory = htmlentities(htmlspecialchars($pureHistory));
        }

        $pureHistory = preg_replace("/\s/ui", ' ', $pureHistory);
        $pureHistory = trim($pureHistory);

        if (!empty($pureHistory)) {
            if (strlen($pureHistory) > $limit) {
                return mb_substr($pureHistory, 0, $limit) . '...';
            }
        }
        return $pureHistory;
    }

    /**
     * Short tooltip with location name
     * @return mixed
     */
    public function tooltipWithName(int $limit = 250, $tags = false)
    {
        // Disable caching for Characters?
        $tooltip = Cache::get($this->tooltipCacheKey(), false);
        if (true || $tooltip === false) {
            $tooltip = $this->cacheTooltip($limit);
        }

        // Add tags afterwards since we can't cache them
        return $this->tooltipAddTags($tooltip, $tags);
    }

    /**
     * Cache the entity's tooltip
     * @param int $limit
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function cacheTooltip(int $limit)
    {
        $text = $this->tooltip($limit);

        // e() isn't enough, remove tags too to avoid ><script injections.
        $name = $this->tooltipName();

        if (empty($text)) {
            return $name;
        }

        $subtitle = $this->tooltipSubtitle();

        $tooltip = '<h4>' . $name . '</h4>' . (!empty($subtitle) ? '<h5>' . $subtitle . '</h5>' : null) .
            '<p class="tooltip-text">' . $text . '</p>';

        return $tooltip;
    }

    /**
     * @return string
     */
    public function tooltipCacheKey(bool $public = false): string
    {
        return 'tooltip_' . $this->id . ($public ? '_public' : null);
    }

    /**
     * Tooltip name
     * @return string
     */
    public function tooltipName(): string
    {
        // e() isn't enough, remove tags too to avoid ><script injections.
        return e(strip_tags($this->name));
    }

    /**
     * Subtitle for the entity's tooltip (ex. character title)
     * @return string
     */
    public function tooltipSubtitle(): string
    {
        return '';
    }

    /**
     * @param string $tooltip
     * @param $tags
     * @return string
     */
    public function tooltipAddTags(string $tooltip, $tags): string
    {
        if ($tags === false) {
            if (empty($this->entity)) {
                return '';
            }
            $tags = $this->entity->tags;
        }

        $html = '';
        /** @var Tag $tag */
        foreach ($tags as $tag) {
            $html .= str_replace('"', '\'', $tag->html());
        }

        if (!empty($html)) {
            $html = '<div class=\'tooltip-tags\'>' . $html . '</div>';
        }

        return $tooltip . $html;
    }
}
