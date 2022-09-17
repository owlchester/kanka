<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BlameableObserver
{
    /**
     * @param Model $model
     */
    public function creating(Model $model): void
    {
        // We need the auth check because of workers having no user
        if (auth()->check()) {
            // @phpstan-ignore-next-line
            $model->created_by = auth()->user()->id;
        }
    }

    /**
     * @param Model $model
     */
    public function updating(Model $model): void
    {
        // Some models don't have an updated_by.
        if (Arr::exists($model->getAttributes(), 'updated_by') && auth()->check()) {
            // @phpstan-ignore-next-line
            $model->updated_by = auth()->user()->id;
        }
    }

    /**
     * @param Model $model
     */
    public function deleting(Model $model): void
    {
        if (auth()->check()) {
            // @phpstan-ignore-next-line
            $model->deleted_by = auth()->user()->id;
        }
    }
}
