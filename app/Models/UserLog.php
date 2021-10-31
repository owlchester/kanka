<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App\Models
 *
 * @var User $user
 * @var string $ip
 * @var int $action_id
 */
class UserLog extends Model
{
    const ACTION_LOGIN = 1;
    const ACTION_LOGOUT = 2;
    const ACTION_LOGIN_FAIL = 3;
    const ACTION_UPDATE = 4;

    /**
     * @var string
     */
    public $table = 'user_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'action_id',
        'ip'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
