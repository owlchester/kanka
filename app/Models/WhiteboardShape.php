<?php

namespace App\Models;

use App\Models\Concerns\Blameable;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $whiteboard_id
 * @property ?int $group_id
 * @property string $type
 * @property int $x
 * @property int $y
 * @property int $width
 * @property int $height
 * @property int $scale_x
 * @property int $scale_y
 * @property int $rotation
 * @property int $z_index
 * @property bool|int $is_locked
 * @property data $shape
 *
 * @property Whiteboard $whiteboard
 * @property ?WhiteboardShape $group
 */
class WhiteboardShape extends Model
{
    use Blameable;
    use SoftDeletes;
    use HasTimestamps;

    public $fillable = [
        'whiteboard_id',
        'group_id',
        'type',
        'x',
        'y',
        'width',
        'height',
        'scale_x',
        'scale_y',
        'rotation',
        'is_locked',
        'z_index',
        'shape',
    ];


    public $casts = [
        'shape' => 'array',
    ];

    public function whiteboard(): BelongsTo
    {
        return $this->belongsTo(Whiteboard::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(WhiteboardShape::class, 'id', 'group_id');
    }
}
