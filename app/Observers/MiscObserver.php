<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\MiscModel;
use App\Observers\Concerns\Copiable;
use App\Facades\Images;
use Illuminate\Support\Str;

abstract class MiscObserver
{
    use Copiable;
    use PurifiableTrait;

    /**
     */
    public function saving(MiscModel $model)
    {
        $model->slug = Str::slug($model->name, '');
        $model->name = trim($model->name); // Remove empty spaces in names

        // If we're from the "move" service, we can skip this part.
        // Or if we are deleting, we don't want to re-do the whole set foreign ids to null
        if (request()->isMethod('delete') === true) {
            return;
        }

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }


    /**
     */
    public function created(MiscModel $model)
    {
        // Created a new sub entity? Create the parent entity.
        $entity = $model->createEntity();

        $this->copy($entity);
    }

    /**
     */
    public function deleted(MiscModel $model)
    {
        // Soft-delete the entity
        if ($model->entity) {
            $model->entity->delete();
        }

        // If soft deleting, don't really delete the image
        // @phpstan-ignore-next-line
        if ($model->trashed()) {
            return;
        }

        Images::cleanup($model);
    }

    /**
     */
    public function saved(MiscModel $model)
    {
        EntityLogger::model($model);
    }
}
