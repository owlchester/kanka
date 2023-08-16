<?php

namespace App\Services\Entity;

use App\Models\Campaign;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class CopyService
{
    use EntityAware;
    use CampaignAware;

    protected Campaign $to;

    public function to(Campaign $campaign): self
    {
        $this->to = $campaign;
        return $this;
    }

    public function copy()
    {

    }
}
