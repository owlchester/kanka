<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;

/**
 * @property int $int
 * @property int $user_id
 * @property int $campaign_id
 * @property ?string $uri
 * @property array $params
 * @property ?float $duration
 * @property ?string $response
 */
class ApiLog extends Model
{
    use Prunable;

    public $connection = 'logs';

    public $casts = [
        'params' => 'array',
    ];

    public $fillable = [
        'user_id',
        'campaign_id',
        'uri',
        'params',
        'duration',
        'response',
    ];

    /**
     * Determines the prunable query.
     */
    public function prunable(): Builder
    {
        return $this->where('created_at', '<=', now()->subDays(30));
    }
}
