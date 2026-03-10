<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Enums\CampaignFlags $flag
 * @property string $value
 */
class CampaignFlag extends Model
{
    use HasCampaign;
    use HasFactory;

    protected $fillable = [
        'flag',
    ];

    public $casts = [
        'flag' => \App\Enums\CampaignFlags::class,
    ];
}
