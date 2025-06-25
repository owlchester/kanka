<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Enums\CampaignFlags $flag
 *
 */
class CampaignFlag extends Model
{
    use HasFactory;
    use HasCampaign;

    public $casts = [
        'flag' => \App\Enums\CampaignFlags::class,
    ];

}
