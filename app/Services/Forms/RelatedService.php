<?php

namespace App\Services\Forms;

use App\Services\Characters\AppearanceService;
use App\Traits\CampaignAware;
use App\Traits\RequestAware;
use App\Traits\UserAware;
use Illuminate\Database\Eloquent\Model;

class RelatedService
{
    use CampaignAware;
    use UserAware;
    use RequestAware;

    protected Model $model;

    public function model(Model $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function process(): void
    {
        if (!property_exists($this->model, 'related') || empty($this->model->related)) {
            return;
        }
        foreach ($this->model->related as $related) {
            /** @var AppearanceService $service */
            $service = app()->make($related);
            $service->request($this->request)
                ->model($this->model)
                ->user($this->user)
                ->process();
        }
    }
}
