<?php

namespace App\Models;

use App\Enums\CampaignFlags;
use App\Models\Concerns\HasCampaign;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property CampaignFlags $flag
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
        'flag' => CampaignFlags::class,
    ];
}
