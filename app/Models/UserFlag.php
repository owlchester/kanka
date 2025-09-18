<?php

namespace App\Models;

use App\Enums\UserFlags;
use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Enums\UserFlags $flag
 *
 * @method static|self|Builder freeTrial()
 */
class UserFlag extends Model
{
    use HasFactory;
    use HasUser;

    public $casts = [
        'flag' => \App\Enums\UserFlags::class,
    ];

    public function scopeFreeTrial(Builder $query): Builder
    {
        return $query->where('flag', UserFlags::freeTrial);
    }

    public function scopeUploadLimit(Builder $query): Builder
    {
        return $query->where('flag', UserFlags::uploadSize);
    }
}
