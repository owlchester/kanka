<?php


namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Referral
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property boolean $is_valid
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
