<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class UserApp
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $access_token
 * @property string $refresh_token
 * @property Carbon $expires_at
 * @property string $identifier
 * @property string|array $settings
 *
 * @property User $user
 *
 * @method static self|Builder app(string $app)
 * @method static self|Builder discord()
 */
class UserApp extends Model
{
    public $fillable = [
        'user_id',
        'app',
        'access_token',
        'refresh_token',
        'expires_at',
        'identifier',
        'settings',
    ];

    public $casts = [
        'expires_at' => 'date',
        'settings' => 'array'
    ];

    /**
     * @param Builder $query
     * @param string $type
     * @return Builder
     */
    public function scopeApp(Builder $query, string $type): Builder
    {
        return $query->where('app', $type);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeDiscord(Builder $query): Builder
    {
        return $this->app('discord');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
