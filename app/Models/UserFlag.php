<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $flag
 */
class UserFlag extends Model
{
    use HasFactory;

    public const FLAG_INACTIVE_1 = 'inactive_1';
    public const FLAG_INACTIVE_2 = 'inactive_2';
    public const FLAG_EMAIL = 'email';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
