<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $shape_id
 * @property string $points
 * @property int $color
 * @property int $width
 */
class WhiteboardStroke extends Model
{
    use HasTimestamps;

    public $fillable = [
        'shape_id',
        'points',
        'color',
        'width',
    ];
}
