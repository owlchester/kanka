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
        if (Auth::check()) {
            $model->created_by = Auth::user()->id;
        }
    }

    /**
     * @param Model $model
     */
    public function updating(Model $model): void
    {
        // Some models don't have an updated_by.
        if (Arr::exists($model->getAttributes(), 'updated_by') && Auth::check()) {
            $model->updated_by = Auth::user()->id;
        }
    }

    /**
     * @param Model $model
     */
    public function deleting(Model $model): void
    {
        if (Auth::check()) {
            $model->deleted_by = Auth::user()->id;
        }
    }
}
