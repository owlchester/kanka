<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Class CampaignDashboardWidgetTag
 * @package App\Models
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

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function widget(): BelongsTo
    {
        return $this->belongsTo(CampaignDashboardWidget::class, 'id', 'widget_id');
    }
}
