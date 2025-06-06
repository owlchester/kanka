<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property \App\Enums\UserFlag $flag
 */
class UserFlag extends Model
{
    use HasFactory;
    use HasUser;

    public $casts = [
        'flag' => \App\Enums\UserFlag::class,
    ];
}
