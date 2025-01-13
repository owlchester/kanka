<?php

namespace App\Services;

use App\Facades\Module;
use App\Traits\CampaignAware;
use App\Traits\EntityAware;
use App\Traits\EntityTypeAware;

class BreadcrumbService
{
    use CampaignAware;
    use EntityAware;
    use EntityTypeAware;

    /**
     */
    public function index(): string
    {
        // Determine the "mode" for logged-in users who prefer the old table view
        $params = [];
        $params['campaign'] = $this->campaign;
        $params['entityType'] = $this->entityType ?? $this->entity->entityType;

        // If the user activated nested views by default, go back to it.
        $entityIndexRoute = route('entities.index', $params);

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
            'label' => $this->entity->name
        ];
    }
}
