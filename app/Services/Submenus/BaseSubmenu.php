<?php

namespace App\Services\Submenus;

use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\UserAware;

class BaseSubmenu
{
    use CampaignAware;
    use EntityAware;
    use UserAware;

    protected array $items;

    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }
}
