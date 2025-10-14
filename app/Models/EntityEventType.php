<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityEventType extends Model
{
    public $casts = [
        'id' => \App\Enums\EntityEventTypes::class,
    ];

    public $timestamps = false;
}
