<?php

namespace App\Services\Submenus;

use App\Traits\CampaignAware;
use Illuminate\Database\Eloquent\Model;

class BaseSubmenu
{
    use CampaignAware;

    protected array $items;
    protected Model $model;

    public function model(Model $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function items(array $items): self
    {
        $this->items = $items;
        return $this;
    }
}
