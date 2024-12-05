<?php

namespace App\Observers;

use App\Facades\Mentions;
use App\Jobs\EntityMappingJob;
use App\Models\MiscModel;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class EntryObserver
{
    use PurifiableTrait;

    public function saving(Model $model)
    {
        // When creating modules through the API, there might be no entry, which is why we need to
        // check if they are in the attributes of the model before interacting with it;
        $attributes = $model->getAttributes();
        // @phpstan-ignore-next-line
        if (!array_key_exists($model->entryFieldName(), $attributes)) {
            return;
        }
        //        dump('Submitted');
        //        dump($model->{$model->entryFieldName()});
        //        dump('Codify');
        //        dump(Mentions::codify($model->{$model->entryFieldName()}));
        // @phpstan-ignore-next-line
        $model->{$model->entryFieldName()} = $this->purify(Mentions::codify($model->{$model->entryFieldName()}));
        //        dump('Becomes');
        //        dd($model->{$model->entryFieldName()});
    }

    public function saved(Model $model)
    {
        // @phpstan-ignore-next-line
        if (!$model->isDirty($model->entryFieldName())) {
            return;
        }
        if ($model instanceof MiscModel) {
            EntityMappingJob::dispatch($model->entity);
        } elseif (method_exists($model, 'mentions')) {
            EntityMappingJob::dispatch($model);
        }
    }
}
