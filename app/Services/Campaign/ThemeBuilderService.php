<?php

namespace App\Services\Campaign;

use App\Models\CampaignStyle;
use App\Traits\CampaignAware;

class ThemeBuilderService
{
    use CampaignAware;

    public function save(?string $config = null)
    {
        $style = $this->getStyle();
        $style->content = $config;
        $style->save();
    }

    protected function getStyle(): CampaignStyle
    {
        $style = CampaignStyle::theme()->first();
        if ($style) {
            return $style;
        }

        $style = new CampaignStyle([
            'name' => 'Campaign theme',
            'is_enabled' => true,
        ]);
        $style->is_theme = true;
        $style->campaign_id = $this->campaign->id;

        return $style;
    }
}
