<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Models\Character;
use App\Traits\CampaignAware;

class CharacterMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'created_at', 'location_id', 'updated_at'];

    public function first(): void
    {
        $this
            ->prepareModel(Character::class)
            ->trackMappings('characters', 'character_id');
    }

    public function prepare(): self
    {
        $this->campaign->characters()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        return $this;
    }
}
