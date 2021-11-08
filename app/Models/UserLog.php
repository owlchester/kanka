<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserLog
 * @package App\Models
 *
 * @property int $user_id
 * @property int $type_id
 * @property string $ip
 */
class UserLog extends Model
{
    const TYPE_LOGIN = 1;
    const TYPE_LOGOUT = 2;
    const TYPE_UPDATE = 4;

    /**
     * @var string
     */
    public $table = 'user_logs';

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type_id',
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
