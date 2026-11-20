<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Ability;

class AbilityMapper extends StandardTreeMapper
{
    protected array $ignore = ['id', 'entry', 'type', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'ability_id', 'created_at', 'updated_at'];

    protected string $className = Ability::class;

    protected string $mappingName = 'abilities';

    public function first(): void
    {
        $this
            ->prepareModel()
            ->trackMappings('ability_id');
    }
}
