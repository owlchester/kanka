<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Traits\CampaignAware;

class CharacterMapper
{
    use CampaignAware;
    use ImportMapper;

    protected array $locations = [];
    protected array $races = [];
    protected array $organisations = [];
}
