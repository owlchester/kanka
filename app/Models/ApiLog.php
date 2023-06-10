<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    public $connection = 'logs';

    public $casts = [
        'params' => 'array',
    ];

    public $fillable = [
        'user_id',
        'campaign_id',
        'uri',
        'params',
    ];
}
