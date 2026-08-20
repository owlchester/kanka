<?php

namespace App\Services\Api;

use App\Models\Entity;
use App\Models\MiscModel;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\StandardEntityCreationService;
use App\Traits\CampaignAware;
use App\Traits\EntityTypeAware;
use App\Traits\UserAware;

class BulkEntityCreatorService
{
    use CampaignAware;
    use EntityTypeAware;
    use UserAware;

    protected MiscModel $new;

    protected Entity $entity;

    protected array $data;

    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected StandardEntityCreationService $entityCreationService,
    ) {}

    public function data(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    public function create(): Entity
    {
        if ($this->entityType->isCustom()) {
            return $this->createEntity();
        }
        $this->new = $this->entityCreationService
            ->campaign($this->campaign)
            ->entityType($this->entityType)
            ->create($this->data);
        $this->entity = $this->new->entity;
        $this->entitySaveService->campaign($this->campaign)->save($this->entity, $this->data);

        return $this->new->entity;
    }

    protected function createEntity(): Entity
    {
        $this->entity = new Entity($this->data);
        $this->entity->type_id = $this->entityType->id;
        $this->entity->campaign_id = $this->campaign->id;
        $this->entity->save();
        $this->entitySaveService->campaign($this->campaign)->save($this->entity, $this->data);

        return $this->entity;
    }
}
