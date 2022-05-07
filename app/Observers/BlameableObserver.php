<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class BlameableObserver
{
    /**
     * @param Model $model
     */
    public function creating(Model $model): void
    {
        // We need the auth check because of workers having no user
        if (auth()->check()) {
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
            $model->updated_by = auth()->user()->id;
        }
    }

    /**
     * @param Model $model
     */
    public function deleting(Model $model): void
    {
        if (auth()->check()) {
            $model->deleted_by = auth()->user()->id;
        }
    }
}
