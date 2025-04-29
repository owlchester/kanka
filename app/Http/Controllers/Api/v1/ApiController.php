<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\MiscModel;

class ApiController extends Controller
{
    /**
     * Hook for MiscModel and Entity objects
     */
    protected function crudSave(MiscModel $model)
    {
        // Fire an event for the Entity Observer.
        $model->crudSaved();

        // Bookmarks have no entity attached to them.
        if (! empty($model->entity)) {
            $model->entity->crudSaved();
            // If the child was changed but nothing changed on the entity, we still want to trigger an update
            if ($model->wasChanged() && ! $model->entity->wasChanged()) {
                $model->entity->touch();
            }
        }
        $model->refresh();
    }
}
