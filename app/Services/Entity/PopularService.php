<?php

namespace App\Services\Entity;

use App\Models\EntityType;
use Illuminate\Database\Eloquent\Collection;

class PopularService
{
    /** @var array|string[] Popular entity types */
    protected array $popularEntityTypes = [
        'character',
        'location',
        'race',
        'item',
        'organisation',
    ];

    public function get(): Collection
    {
        return EntityType::whereIn('code', $this->popularEntityTypes)->get();
    }
}
