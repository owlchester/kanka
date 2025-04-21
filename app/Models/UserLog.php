<?php

namespace App\Models;

use App\Enums\UserAction;
use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 *
 * @property UserAction $type_id
 * @property ?string $ip
 * @property ?string $country
 * @property ?int $campaign_id
 * @property array $data
 * @property Carbon $created_at
 */
class UserLog extends Model
{
    use HasUser;
    use MassPrunable;

    public $connection = 'logs';

    public $table = 'user_logs';

    protected $casts = [
        'type_id' => UserAction::class,
        'data' => 'array',
    ];

    protected $fillable = [
        'user_id',
        'type_id',
        'ip',
        'campaign_id',
        'data',
    ];

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        return static::where('updated_at', '<=', now()->subMonths(6));
    }

    public function scopeLogins(Builder $builder): Builder
    {
        return $builder->whereIn('type_id', [UserAction::login->value, UserAction::autoLogin->value]);
    }
}
