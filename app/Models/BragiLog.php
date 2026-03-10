<?php

namespace App\Models;

use App\Models\Concerns\HasCampaign;
use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $prompt
 * @property string $result
 * @property array $data
 */
class BragiLog extends Model
{
    use HasCampaign;
    use HasUser;

    public $casts = [
        'data' => 'array',
    ];

    public function scopeRecent(Builder $query, $cutoffDate): Builder
    {
        return $query
            ->whereDate('created_at', '>=', $cutoffDate);
    }
}
