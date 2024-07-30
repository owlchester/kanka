<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Models\MiscModel;
use App\Services\EntityMappingService;
use Illuminate\Database\Eloquent\Model;

class EntryObserver
{
    use PurifiableTrait;

    protected EntityMappingService $entityMappingService;

    public function __construct(EntityMappingService $entityMappingService)
    {
        $this->entityMappingService = $entityMappingService;
    }

    public function saving(Model $model)
    {
        // When creating modules through the API, there might be no entry, which is why we need to
        // check if they are in the attributes of the model before interacting with it;
        $attributes = $model->getAttributes();
        // @phpstan-ignore-next-line
        if (!array_key_exists($model->entryFieldName(), $attributes)) {
            return;
        }
        // @phpstan-ignore-next-line
        $model->{$model->entryFieldName()} = $this->purify(Mentions::codify($model->{$model->entryFieldName()}));
    }

    public function saved(Model $model)
    {
        // @phpstan-ignore-next-line
        if ($model->isDirty($model->entryFieldName())) {
            if ($model instanceof MiscModel) {
                $this->entityMappingService->with($model->entity)->silent()->map();
            } elseif (method_exists($model, 'mentions')) {
                $this->entityMappingService->with($model)->silent()->map();
            }
        }
    }
}
