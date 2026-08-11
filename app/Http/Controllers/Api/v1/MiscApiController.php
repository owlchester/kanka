<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\MiscModel;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;
use App\Services\Entity\StandardEntityCreationService;
use CampaignLocalization;

class MiscApiController extends ApiController
{
    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected EntityRelationsServiceFactory $relationsFactory,
        protected StandardEntityCreationService $entityCreationService,
    ) {}

    protected function createStandardModel(Campaign $campaign, array $data, int $entityTypeId): MiscModel
    {
        return $this->entityCreationService
            ->campaign($campaign)
            ->entityType(EntityType::findOrFail($entityTypeId))
            ->create($data);
    }

    protected function crudSave(MiscModel $model, array $data): void
    {
        $service = $this->relationsFactory->for($model->entity);
        if (request()->isMethod('patch')) {
            $service?->patch();
        }
        $service?->save($model, $data);

        if (! empty($model->entity)) {
            $campaign = CampaignLocalization::getCampaign();
            $this->entitySaveService->campaign($campaign)->save($model->entity, $data);
            if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                $model->entity->touch();
            }
        }
        $model->refresh();
    }
}
