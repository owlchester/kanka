<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EntityListingPreference extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'type_id',
        'visible_columns',
        'layout',
        'nested',
        'per_page',
    ];

    protected function casts(): array
    {
        return [
            'visible_columns' => 'array',
            'nested' => 'boolean',
            'per_page' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class);
    }

    public function entityType(): BelongsTo
    {
        return $this->belongsTo(EntityType::class, 'type_id');
    }
}
