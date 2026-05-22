<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
    use HasUser;

    public $fillable = [
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

    public function isTwoFactorVerified(): bool
    {
        return $this->two_factor_verified_at !== null
            && $this->two_factor_verified_at->gte(now()->subDays(30));
    }
}
