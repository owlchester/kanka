<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property ?string $session_id
 * @property ?string $ip_address
 * @property ?string $user_agent
 * @property ?Carbon $two_factor_verified_at
 * @property Carbon $last_active_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UserDevice extends Model
{
    protected $fillable = [
        'user_id',
        'token',
        'session_id',
        'ip_address',
        'user_agent',
        'two_factor_verified_at',
        'last_active_at',
    ];

    protected function casts(): array
    {
        return [
            'two_factor_verified_at' => 'datetime',
            'last_active_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isTwoFactorVerified(): bool
    {
        return $this->two_factor_verified_at !== null
            && $this->two_factor_verified_at->gte(now()->subDays(30));
    }
}
