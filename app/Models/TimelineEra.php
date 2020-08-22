<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class TimelineEra
 * @package App\Models
 *
 * @property int $id
 * @property int $timeline_id
 * @property string $name
 * @property string $entry
 * @property string $abbreviation
 * @property int $start_year
 * @property int $end_year
 *
 * @property Timeline $timeline
 * @property TimelineElement[] $elements
 *
 * @method static self|Builder ordered()
 */
class TimelineEra extends Model
{
    /** Fillable fields */
    protected $fillable = [
        'timeline_id',
        'name',
        'abbreviation',
        'entry',
        'start_year',
        'end_year',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeline()
    {
        return $this->belongsTo(Timeline::class, 'timeline_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function elements()
    {
        return $this->hasMany(TimelineElement::class, 'era_id');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrdered(Builder $query, bool $revertOrder = false)
    {
        return $query
            ->orderBy('start_year', ($revertOrder ? 'asc' : 'desc'))
            ->orderBy('end_year', ($revertOrder ? 'desc' : 'asc'))
            ->orderBy('name');
    }
}
