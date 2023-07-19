<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $slug
 */
class Genre extends Model
{
    public $fillable = [
        'slug',
        'campaign_count',
    ];
}
