<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property int $campaign_id
 * @property string $prompt
 * @property string $result
 * @property array $data
 */
class BragiLog extends Model
{
    public $casts = [
        'data' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeRecent(Builder $query, $cutoffDate): Builder
    {
        return $query
            ->whereDate('created_at', '>=', $cutoffDate);
    }
}
