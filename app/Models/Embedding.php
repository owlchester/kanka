<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Embedding extends Model
{

    public $connection = 'vector_pgsql';

    public $casts = [
        'embedding' => 'array',
    ];

    public $fillable = [
        'campaign_id',
        'embedding',
        'parent_id',
        'parent_type',
    ];

    public function parent()
    {
        return $this->morphTo();
    }

    public function scopeNearest($query, array $embedding, int $limit = 5)
    {
        $embeddingString = '[' . implode(',', $embedding) . ']';
        return $query
            ->orderByRaw("embedding <=> ?::vector", [$embeddingString])
            ->limit($limit);
    }
}
