<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;

class CampaignSetting extends Model
{
    /**
     * @var string
     */
    public $table = 'campaign_settings';

    /**
     * @var array
     */
    protected $fillable = [
        'characters',
        'events',
        'families',
        'items',
        'journals',
        'locations',
        'notes',
        'organisations',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo('App\Campaign', 'campaign_id', 'id');
    }
}
