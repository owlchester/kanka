<?php

namespace App\Models;

use App\Facades\Avatar;
use App\Models\Concerns\Blameable;
use App\Observers\WhiteboardShapeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

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
 * @property array $shape
 * @property Whiteboard $whiteboard
 * @property ?WhiteboardShape $group
 * @property WhiteboardStroke[]|Collection $strokes
 */
#[ObservedBy(WhiteboardShapeObserver::class)]
class WhiteboardShape extends Model
{
    use Blameable;
    use HasTimestamps;
    use SoftDeletes;

    public $fillable = [
        'whiteboard_id',
        'group_id',
        'type',
        'x',
        'y',
        'width',
        'height',
        'rotation',
        'is_locked',
        'z_index',
        'shape',
        // Transistent ui data
        'scale_x',
        'scale_y',
    ];

    public $casts = [
        'x' => 'float',
        'y' => 'float',
        'width' => 'float',
        'height' => 'float',
        'rotation' => 'float',
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

    public function strokes(): HasMany
    {
        return $this->hasMany(WhiteboardStroke::class, 'shape_id');
    }

    public function isRectangle(): bool
    {
        return $this->type === 'rect';
    }

    public function isCircle(): bool
    {
        return $this->type === 'circle';
    }

    public function isText(): bool
    {
        return $this->type === 'text';
    }

    public function isEntity(): bool
    {
        return $this->type === 'entity';
    }

    public function isImage(): bool
    {
        return $this->type === 'image';
    }

    public function isDrawing(): bool
    {
        return $this->type === 'drawing';
    }

    public function image(): ?string
    {
        if ($this->isImage()) {
            $image = Image::find($this->shape['uuid']);
            if ($image) {
                return $image->url();
            }
        } elseif ($this->isEntity()) {
            $entity = Entity::find($this->shape['entity_id']);
            if ($entity) {
                return Avatar::entity($entity)->size(256)->fallback()->thumbnail();
            }
        }
        return null;
    }
}
