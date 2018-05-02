<?php

namespace App\Models;

use App\Models\MiscModel;
use App\Traits\VisibleTrait;

/**
 * Class EntityEvent
 * @package App\Models
 *
 * @property integer $entity_id
 * @property integer $calendar_id
 * @property string $date
 * @property string $comment
 * @property boolean $is_recurring
 * @property boolean $is_private
 */
class EntityEvent extends MiscModel
{
    /**
     * Traits
     */
    //use VisibleTrait;

    /**
     * @var string
     */
    public $table = 'entity_events';

    /**
     * @var array
     */
    protected $fillable = ['calendar_id', 'entity_id', 'date', 'comment', 'is_recurring'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function calendar()
    {
        return $this->belongsTo('App\Models\Calendar', 'calendar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entity()
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    public function getDate()
    {
        $date = explode('-', $this->date);

        // Replace month with real month, and year maybe
        $months = $this->calendar->months();
        $years = $this->calendar->years();

        return $date[2] . ' ' .
            (isset($months[$date[1]-1]) ? $months[$date[1]-1]['name'] : $date[1]) . ', ' .
            (isset($years[$date[0]]) ? $years[$date[0]] : $date[0]) . ' ' .
            $this->calendar->suffix;
    }
}
