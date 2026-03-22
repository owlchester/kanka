<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\MiscModel;
use App\Services\Entity\EntitySaveService;
use App\Services\Entity\Relations\EntityRelationsServiceFactory;

class ApiController extends Controller
{
    public function __construct(
        protected EntitySaveService $entitySaveService,
        protected EntityRelationsServiceFactory $relationsFactory,
    ) {}

    /**
     * Hook for MiscModel and Entity objects
     */
    protected function crudSave(MiscModel $model, array $data): void
    {
        $this->relationsFactory->for($model->entity)?->save($model, $data);

        if (! empty($model->entity)) {
            $this->entitySaveService->save($model->entity, $data);
            if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                $model->entity->touch();
            }
        }
        $model->refresh();
    }
}
