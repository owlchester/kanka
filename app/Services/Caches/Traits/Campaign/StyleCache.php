<?php

namespace App\Services\Caches\Traits\Campaign;

use App\Models\CampaignStyle;

trait StyleCache
{
    /**
     * Build campaign styles
     */
    public function styles(): string
    {
        $key = $this->stylesKey();
        if ($this->has($key)) {
            return (string) $this->get($key);
        }

        $css = "/**\n * Campaign Styles for campaign #" . $this->campaign->id . "\n */\n\n";
        foreach ($this->campaign->styles()->enabled()->defaultOrder()->get() as $style) {
            /** @var CampaignStyle $style */
            $css .= "/** Style " . $style->name . "#" . $style->id . " */\n" . $style->content() . "\n";
        }

        $this->forever($key, $css);
        return (string) $css;
    }

    public function stylesTimestamp(): int
    {
        $key = $this->stylesTsKey();
        if ($this->has($key)) {
            return (int) $this->get($key);
        }

        $ts = time();
        $this->forever($key, $ts);
        return (int) $ts;
    }

    public function clearStyles(): self
    {
        $this->forget(
            $this->stylesKey()
        );
        $this->forget(
            $this->stylesTsKey()
        );
        return $this;
    }

    protected function stylesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_styles';
    }

    protected function stylesTsKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_styles_ts';
    }
}
