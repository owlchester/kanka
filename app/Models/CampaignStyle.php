<?php


namespace App\Models;


use App\Models\Concerns\SortableTrait;
use App\Traits\CampaignTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class CampaignStyle
 * @package App\Models
 *
 * @property int $id
 * @property int $campaign_id
 * @property int $created_by
 * @property string $name
 * @property string $content
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property bool $is_enabled
 * @property int $order
 *
 * @method static self|Builder enabled($enabled = true)
 */
class CampaignStyle extends Model
{
    use SoftDeletes, CampaignTrait, SortableTrait;

    public $fillable = [
        'name',
        'content',
        'is_enabled',
        'order',
    ];

    public $sortable = [
        'name',
        'updated_at',
        'is_enabled',
        'order',
    ];

    public $defaultSort = ['order', 'id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    /**
     * @param Builder $query
     * @param bool $enabled
     * @return Builder
     */
    public function scopeEnabled(Builder $query, $enabled = true)
    {
        return $query->where('is_enabled', $enabled);
    }

    /**
     * @return string
     */
    public function length(): string
    {
        return (string) number_format(strlen($this->content));
    }

    /**
     * @param string $sub
     * @return string
     */
    public function url(string $sub): string
    {
        return 'campaign_styles.' . $sub;
    }

}
