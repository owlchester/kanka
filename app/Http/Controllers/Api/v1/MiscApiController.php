<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\MiscModel;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;

class MiscApiController extends ApiController
{
    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected EntityRelationsServiceFactory $relationsFactory,
    ) {}

    protected function crudSave(MiscModel $model, array $data): void
    {
        $service = $this->relationsFactory->for($model->entity);
        if (request()->isMethod('patch')) {
            $service?->patch();
        }
        $service?->save($model, $data);

        if (! empty($model->entity)) {
            $this->entitySaveService->save($model->entity, $data);
            if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                $model->entity->touch();
            }
        }
        $model->refresh();
    }
}
