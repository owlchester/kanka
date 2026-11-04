<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntitySheet extends Model
{
    protected $fillable = ['entity_id', 'source', 'reference', 'sort_order'];

    public function entity(): BelongsTo
    {
        return $this->belongsTo(Entity::class);
    }
}
