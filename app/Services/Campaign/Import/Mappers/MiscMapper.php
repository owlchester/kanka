<?php

namespace App\Services\Campaign\Import\Mappers;

use App\Services\Campaign\Import\ImportMentions;
use App\Traits\CampaignAware;
use App\Traits\UserAware;

abstract class MiscMapper
{
    use CampaignAware;
    use EntityMapper;
    use BaseEntityMapper;
    use ImportMapper;
    use ImportMentions;
    use UserAware;

    protected array $mapping = [];

    protected array $parents = [];

    protected string $className;

    protected string $mappingName;

    public function prepare(): self
    {
        // $this->campaign->{$this->mappingName}()->forceDelete();
        return $this;
    }

    public function third(): self
    {
        $this
            ->loadModel()
            ->entityThird();

        return $this;
    }

    public function tree(): self
    {
        return $this;
    }
}
