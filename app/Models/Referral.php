<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Referral
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property bool|int $is_valid
 * @property int $user_id
 *
 * @property User $user
 * @property User[] $users
 */
class Referral extends Model
{
    /**
     * Users who used the referral
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Partner attached to the referral
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
