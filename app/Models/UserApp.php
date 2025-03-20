<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserApp
 *
 * @property int $id
 * @property string $type
 * @property string $access_token
 * @property string $refresh_token
 * @property Carbon $expires_at
 * @property string $identifier
 * @property string|array $settings
 *
 * @method static self|Builder app(string $app)
 * @method static self|Builder discord()
 */
class UserApp extends Model
{
    use HasUser;

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
        'settings' => 'array',
    ];

    public function scopeApp(Builder $query, string $type): Builder
    {
        return $query->where('app', $type);
    }

    public function scopeDiscord(Builder $query): Builder
    {
        return $this->app('discord');
    }
}
