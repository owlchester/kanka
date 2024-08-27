<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 */
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}
