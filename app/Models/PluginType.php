<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class PluginType extends Model
{
    public const TYPE_THEME = 1;
    public const TYPE_ATTRIBUTE = 2;
    public const TYPE_PACK = 3;
}
