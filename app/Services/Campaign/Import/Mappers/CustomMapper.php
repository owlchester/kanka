<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Services\Campaign\Import\ImportMentions;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

class CustomMapper
{
    use BaseEntityMapper;
    use CampaignAware;
    use CustomEntityMapper;
    use ImportMapper;
    use ImportMentions;
    use UserAware;

    protected array $mapping = [];

    protected array $parents = [];

    protected array $ignore = ['id', 'campaign_id', 'slug', 'image', '_lft', '_rgt', 'parent_id', 'created_at', 'updated_at'];

    protected string $mappingName;

    public function prepare(): self
    {
        return $this;
    }

    public function first(): void
    {
        $this
            ->prepareEntity()
            ->trackMappings('parent_id');
    }

    public function second(): void
    {
        $this
            ->loadEntity()
            ->saveEntity()
            ->entitySecond();
    }

    public function third(): self
    {
        $this
            ->loadEntity()
            ->entityThird();

        return $this;
    }
}
