<?php

namespace App\Services\Submenus;

use App\Models\MiscModel;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use Illuminate\Database\Eloquent\Model;

class BaseSubmenu
{
    use CampaignAware;
    use EntityAware;

    protected array $items;

    public function items(array $items): self
    {
        $this->items = $items;
        return $this;
    }
}
