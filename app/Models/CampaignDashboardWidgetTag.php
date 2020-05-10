<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignDashboardWidgetTag
 * @package App\Models
 *
 * @property int $widget_id
 * @property int $tag_id
 * @property Tag $tag
 * @property CampaignDashboardWidget $widget
 */
class CampaignDashboardWidgetTag extends Model
{
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function widget()
    {
        return $this->belongsTo(CampaignDashboardWidget::class, 'id', 'widget_id');
    }
}
