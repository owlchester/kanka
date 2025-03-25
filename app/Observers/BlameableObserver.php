<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BlameableObserver
{
    public function creating(Model $model): void
    {
        // We need the auth check because of workers having no user
        if (auth()->check()) {
            // @phpstan-ignore-next-line
            $model->created_by = auth()->user()->id;
        }
    }

    public function updating(Model $model): void
    {
        // Some models don't have an updated_by.
        if (Arr::exists($model->getAttributes(), 'updated_by') && auth()->check()) {
            // @phpstan-ignore-next-line
            $model->updated_by = auth()->user()->id;
        }
    }

    public function deleted(Model $model): void
    {
        if (Arr::exists($model->getAttributes(), 'deleted_by') && auth()->check()) {
            // @phpstan-ignore-next-line
            $model->deleted_by = auth()->user()->id;

            if (
                method_exists($model, 'useSoftDeletes') && $model->isDirty()
            ) {
                // Using softDeletes makes an update() on the model but only on the deleted_at field,
                // so we need to do another write to the db because it's dumb.
                $model->updateQuietly();
            }
        }
    }
}
