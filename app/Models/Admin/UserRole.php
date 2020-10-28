<?php


namespace App\Models\Admin;


use App\Models\Concerns\CompositeKey;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use CompositeKey;

    public $table = 'user_roles';

    public $primaryKey = [
        'user_id',
        'role_id',
    ];
    public $fillable = [
        'user_id',
        'role_id',
    ];

    public $timestamps = false;
    public $incrementing = false;
}
