<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EntityEventType extends Model
{
    public const int BIRTH = 2;
    public const int DEATH = 3;
    public const int CALENDAR_DATE = 4;
    public const int FOUNDED = 5;

    public $timestamps = false;
}
