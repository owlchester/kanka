<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Referral
 * @package App\Models
 *
 * @property int $id
 * @property string $code
 * @property bool|int $is_valid
 *
 * @property User[] $users
 */
class Referral extends Model
{
    use HasUser;

    /**
     * Users who used the referral
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
