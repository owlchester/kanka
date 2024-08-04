<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Builder;

/**
 * @property int $id
 * @property string $token
 * @property bool|int $is_valid
 *
 * @method static self|Builder valid()
 */
class UserValidation extends Model
{
    use HasUser;
    use Prunable;

    protected $fillable = [
        'is_valid',
        'token'
    ];

    public function getRouteKeyName()
    {
        return 'token';
    }

    /**
     * Automatically prune old elements from the db
     */
    public function prunable(): Builder
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
