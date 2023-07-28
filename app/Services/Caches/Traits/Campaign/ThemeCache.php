<?php

namespace App\Services\Caches\Traits\Campaign;

trait ThemeCache
{
    public function clearTheme(): self
    {
        $this->forget(
            $this->themeKey()
        );
        return $this;
    }

    protected function themeKey(): string
    {
        return 'campaign_' . $this->campaign->id . '_theme';
    }
}
