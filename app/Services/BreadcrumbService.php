<?php

namespace App\Services;

use App\Facades\Module;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;

class BreadcrumbService
{
    use CampaignAware;
    use EntityAware;

    /**
     */
    public function index(string $name): string
    {
        // Determine the "mode" for logged-in users who prefer the old table view
        $params = [];
        $params['campaign'] = $this->campaign;

        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route($name . '.index', $params);

        return $entityIndexRoute;
    }

    public function list(): array
    {
        $fallback = __('entities.' . $this->entity->pluralType());
        return [
            'url' => $this->index($this->entity->pluralType()),
            'label' => Module::plural($this->entity->typeId(), $fallback)
        ];
    }

    public function show(): array
    {
        return [
            'url' => route('entities.show', [$this->campaign, $this->entity]),
            'label' => $this->entity->name
        ];
    }
}
