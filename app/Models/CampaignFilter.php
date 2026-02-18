<?php

namespace App\Models;

use App\Enums\CampaignFilterType;
use Illuminate\Database\Eloquent\Model;

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
