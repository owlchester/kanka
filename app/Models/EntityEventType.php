<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityEventType extends Model
{
    public const BIRTH = 2;
    public const DEATH = 3;
    public const CALENDAR_DATE = 4;
    public const FOUNDED = 5;

    public $timestamps = false;
}
