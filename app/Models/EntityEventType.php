<?php

namespace App\Models;

use App\Enums\EntityEventTypes;
use Illuminate\Database\Eloquent\Model;

class EntityEventType extends Model
{
    public $casts = [
        'id' => EntityEventTypes::class,
    ];

    public $timestamps = false;
}
