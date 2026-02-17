<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $event
 * @property array $metadata
 */
class CampaignEvent extends Model
{
    use HasCampaign;
    use HasTimestamps;
    use Blameable;

    public $fillable = [
        'campaign_id',
        'created_by',
        'event',
        'metadata'
    ];

    public $casts = [
        'metadata' => 'array'
    ];
}
