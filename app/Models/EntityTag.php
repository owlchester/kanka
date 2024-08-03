<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EntityCategory
 * @package App\Models
 *
 * @property int $entity_id
 * @property int $tag_id
 * @property Tag $tag
 * @property Entity $entity
 */
class EntityTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'entity_id',
        'tag_id',
    ];

    public function tag(): BelongsTo
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    public function entity(): BelongsTo
    {
        return $this->belongsTo('App\Models\Entity', 'entity_id');
    }

    public function exportFields(): array
    {
        return [
            'tag_id',
        ];
    }
}
