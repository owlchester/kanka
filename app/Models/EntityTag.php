<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class EntityTag
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Tag, $this>
     */
    public function tag(): BelongsTo
    {
        return $this->belongsTo('App\Models\Tag', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Entity, $this>
     */
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
