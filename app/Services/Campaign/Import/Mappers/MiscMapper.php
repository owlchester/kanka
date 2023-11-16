<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Traits\CampaignAware;
use App\Traits\UserAware;

abstract class MiscMapper
{
    use CampaignAware;
    use ImportMapper;
    use EntityMapper;
    use UserAware;

    protected array $mapping = [];
    protected array $parents = [];

    protected string $className;
    protected string $mappingName;

    public function prepare(): self
    {
        $this->campaign->{$this->mappingName}()->forceDelete();
        return $this;
    }

    public function tree(): self
    {
        return $this;
    }
}
