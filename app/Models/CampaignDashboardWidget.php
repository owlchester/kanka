<?php

namespace App\Models;

use App\Traits\AclTrait;
use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

/**
 * Class CampaignDashboardWidget
 * @package App\Models
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $entity_id
 * @property string $widget
 * @property string $config
 * @property integer $width
 * @property integer $position
 * @property Tag[] $tags
 * @property Entity $entity
 *
 * @method static self|Builder positioned()
 */
class CampaignDashboardWidget extends Model
{
    /**
     * Widget Constants
     */
    const WIDGET_PREVIEW = 'preview';
    const WIDGET_RECENT = 'recent';
    const WIDGET_CALENDAR = 'calendar';
    const WIDGET_UNMENTIONED = 'unmentioned';
    const WIDGET_RANDOM = 'random';

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
        'width',
        'is_full',
    ];

    protected $casts = [
        'config' => 'Array',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(
            'App\Models\Tag',
            'campaign_dashboard_widget_tags',
            'widget_id',
            'tag_id',
            'id',
            'id'
        );
    }

    /**
     * Get the column size
     * @return int
     */
    public function colSize(): int
    {
        if (!empty($this->width)) {
            return $this->width;
        }
        return ($this->widget == self::WIDGET_PREVIEW || $this->widget == self::WIDGET_RANDOM ||
            ($this->widget == self::WIDGET_RECENT && $this->conf('singular')))
            ? 4 : 6;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopePositioned($query)
    {
        return $query->with(['entity', 'tags'])
            ->orderBy('position', 'asc');
    }

    /**
     * @param $value
     */
    public function conf($value)
    {
        return Arr::get($this->config, $value, null);
    }


    /**
     * Used by the API to get models updated since a previous date
     * @param $query
     * @param $lastSync
     * @return mixed
     */
    public function scopeLastSync(\Illuminate\Database\Eloquent\Builder $query, $lastSync)
    {
        if (empty($lastSync)) {
            return $query;
        }
        return $query->where('updated_at', '>', $lastSync);
    }
}
