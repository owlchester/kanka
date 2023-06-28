<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    public $fillable = [
        'slug',
        'campaign_count',
    ];
}
