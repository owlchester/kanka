<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $user_id
 * @property string $code
 */
class Tutorial extends Model
{
    public $table = 'user_tutorials';
}
