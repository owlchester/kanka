<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property int $user_id
 * @property string $token
 * @property bool $is_valid
 * @property User $user
 *
 * @method static self|Builder valid()
 */
class UserValidation extends Model
{
    use Prunable;

    /** @var string[]  */
    protected $fillable = [
        'is_valid',
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Automatically prune old elements from the db
     * @return Builder
     */
    public function prunable()
    {
        return static::where('is_valid', false)->where('created_at', '<=', now()->subDays(1));
    }

    /**
     */
    public function scopeValid(Builder $query, bool $valid = true): Builder
    {
        return $query->where(['is_valid' => $valid]);
    }
}
