<?php

namespace App\Services\Caches\Traits\Campaign;

use App\Models\CampaignStyle;
use Illuminate\Support\Facades\Cache;

trait StyleCache
{
    /**
     * Build campaign styles
     */
    public function styles(): string
    {
        $key = $this->stylesKey();

        return Cache::remember($key, 24 * 3600, function () {
            $css = "/**\n * Campaign Styles for campaign #" . $this->campaign->id . "\n */\n\n";
            $styles = $this->campaign
                ->styles()
                ->enabled()
                ->defaultOrder()
                ->get();
            foreach ($styles as $style) {
                /** @var CampaignStyle $style */
                if ($style->isTheme()) {
                    $css .= '/** Theme builder #' . $style->id . " */\n@layer theme {\n" . $style->content() . "\n}\n";

                    continue;
                }
                $css .= '/** Style ' . $style->name . '#' . $style->id . " */\n" . $style->content() . "\n";
            }

            return $css;
        });
    }

    public function stylesTimestamp(): int
    {
        return (int) $this->primary($this->campaign->id)->get('time');
    }

    public function clearStyles(): self
    {
        $this->forget(
            $this->stylesKey()
        );

        return $this;
    }

    protected function stylesKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_styles';
    }
}
