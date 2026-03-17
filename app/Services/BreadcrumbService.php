<?php

namespace App\Services;

use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;

class BreadcrumbService
{
    use CampaignAware;
    use EntityAware;
    use EntityTypeAware;

    public function index(?string $name = null): string
    {
        // Determine the "mode" for logged-in users who prefer the old table view
        $params = [];
        $params['campaign'] = $this->campaign;

        if (isset($this->entityType) && $this->entityType->hasEntity()) {
            $params['entityType'] = $this->entityType;
            $entityIndexRoute = route('entities.index', $params);
        } elseif (isset($this->entity) && $this->entity->entityType->hasEntity()) {
            $params['entityType'] = $this->entity->entityType;
            $entityIndexRoute = route('entities.index', $params);
        } else {
            $entityIndexRoute = route($name . '.index', $params);
        }

        return $entityIndexRoute;
    }

    public function list(): array
    {
        return [
            'url' => $this->index(),
            'label' => isset($this->entityType) ? $this->entityType->plural() : $this->entity->entityType->plural(),
        ];
    }

    public function show(): array
    {
        return [
            'url' => route('entities.show', [$this->campaign, $this->entity]),
            'label' => $this->entity->name,
        ];
    }
}
