<?php

namespace App\Models;

use App\Enums\UserAction;
use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\MassPrunable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserLog
 *
 * @property UserAction $type_id
 * @property ?string $ip
 * @property ?string $country
 * @property ?int $campaign_id
 * @property array $data
 * @property ?int $impersonated_by
 * @property Carbon $created_at
 * @property ?User $impersonator
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
        'impersonated_by',
    ];

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
    {
        $cutoff = config('logging.prune_months');

        return static::where('updated_at', '<=', now()->subMonths($cutoff));
    }

    public function scopeLogins(Builder $builder): Builder
    {
        return $builder->whereIn('type_id', [UserAction::login->value, UserAction::autoLogin->value]);
    }

    public function impersonator(): BelongsTo
    {
        $this->setConnection(config('database.default'));

        return $this->belongsTo(User::class, 'impersonated_by');
    }

    public function user(): BelongsTo
    {
        $this->setConnection(config('database.default'));

        return $this->belongsTo(User::class, $this->getUserFieldName());
    }

    public function requiresPremium(): bool
    {
        $cutoff = config('limits.campaigns.logs.standard');

        return $this->created_at->diffInDays() > $cutoff;
    }
}
