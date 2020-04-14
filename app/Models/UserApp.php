<?php


namespace App\Models;


use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @property string $settings
 *
 * @property User $user
 *
 * @method self app(string $app)
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

    public $dates = [
        'expires_at'
    ];

    public $casts = [
        'settings' => 'array'
    ];

    /**
     * @param $query
     * @param string $type
     * @return mixed
     */
    public function scopeApp($query, string $type)
    {
        return $query->where('app', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
