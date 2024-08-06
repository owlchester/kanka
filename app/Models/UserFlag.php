<?php

namespace App\Models;

use App\Models\Concerns\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $flag
 */
class UserFlag extends Model
{
    use HasFactory;
    use HasUser;

    public const string FLAG_INACTIVE_1 = 'inactive_1';
    public const string FLAG_INACTIVE_2 = 'inactive_2';
    public const string FLAG_EMAIL = 'email';
}
