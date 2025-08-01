<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignDashboardWidgetTag
 *
 * @property int $widget_id
 * @property int $tag_id
 * @property Tag $tag
 * @property CampaignDashboardWidget $widget
 */
class CampaignDashboardWidgetTag extends Pivot
{
    public $timestamps = false;

    public $table = 'campaign_dashboard_widget_tags';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Tag, $this>
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\CampaignDashboardWidget, $this>
     */
    public function widget(): BelongsTo
    {
        return $this->belongsTo(CampaignDashboardWidget::class, 'id', 'widget_id');
    }
}
