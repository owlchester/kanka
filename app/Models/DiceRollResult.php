<?php

namespace App\Models;

use App\Traits\CampaignTrait;
use App\Traits\VisibleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class DiceRollResult extends MiscModel
{
    //
    protected $fillable = [
        'dice_roll_id',
        'created_by',
        'results',
        'is_private',
    ];

    /**
     * Fields that can be filtered on
     * @var array
     */
    protected $filterableColumns = [
        'dice_roll_id',
        'created_at',
        'created_by',
        'diceRoll-character_id',
    ];

    protected $defaultOrderField = 'created_at';
    protected $defaultOrderDirection = 'DESC';

    /**
     *
     */
    public function newQuery()
    {
        return parent::newQuery()->whereHas('diceRoll', function($query) {
            $query->where('campaign_id', Session::get('campaign_id'));
        });
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * Who created this entry
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function diceRoll()
    {
        return $this->belongsTo('App\Models\DiceRoll', 'dice_roll_id');
    }

    public function character()
    {
        return $this->diceRoll->character();
    }
}
