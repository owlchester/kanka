<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $shape_id
 * @property string $points
 * @property string $color
 * @property int $width
 * @property WhiteboardShape $shape;
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

    public function shape(): BelongsTo
    {
        return $this->belongsTo(WhiteboardShape::class);
    }
    function unpack(int $scale = 1000): array
    {
        $points = [];
        $len = strlen($this->points);

        for ($i = 0; $i < $len; $i += 16) {
            $x = unpack('q', substr($this->points, $i, 8))[1];
            $y = unpack('q', substr($this->points, $i + 8, 8))[1];

            $points[] = $x / $scale;
            $points[] = $y / $scale;
        }

        return $points;
    }
}
