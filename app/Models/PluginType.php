<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PluginType extends Model
{
    public const int TYPE_THEME = 1;

    public const int TYPE_ATTRIBUTE = 2;

    public const int TYPE_PACK = 3;
}
