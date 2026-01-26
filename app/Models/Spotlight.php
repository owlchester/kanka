<?php

namespace App\Models;

use App\Enums\SpotlightStatus;
use App\Models\Concerns\HasCampaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $url
 * @property Carbon $featured_at
 * @property ?int $featured_by
 * @property int $status
 */
class Spotlight extends Model
{
    use HasCampaign;
    use HasTimestamps;

    public $casts = [
        'status' => SpotlightStatus::class,
    ];
}
