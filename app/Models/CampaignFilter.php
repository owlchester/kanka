<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\CampaignFilterType;

class CampaignFilter extends Model
{
    protected $fillable = ['campaign_id', 'type', 'entry'];

    protected $casts = [
        'type' => CampaignFilterType::class,
    ];

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}