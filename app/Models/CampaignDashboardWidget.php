<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CampaignDashboardWidget
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $entity_id
 * @property string $widget
 * @property string $config
 * @property integer $position
 */
class CampaignDashboardWidget extends Model
{
    /**
     * Widget Constants
     */
    const WIDGET_PREVIEW = 'preview';
    const WIDGET_RECENT = 'recent';
    const WIDGET_CALENDAR = 'calendar';

    /**
     * Traits
     */
    use CampaignTrait;

    /**
     * @var array
     */
    protected $fillable = [
        'campaign_id',
        'entity_id',
        'widget',
        'config',
        'position',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(\App\Models\Campaign::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo(\App\Models\Entity::class);
    }

    public function colSize()
    {
        return 4;
    }
}