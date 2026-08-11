<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Facades\Images;
use App\Models\MiscModel;
use Closure;

class ChildEntityObserver
{
    protected static bool $skipParentCreation = false;

    public static function withoutParentCreation(Closure $callback): mixed
    {
        $previous = self::$skipParentCreation;
        self::$skipParentCreation = true;

        try {
            return $callback();
        } finally {
            self::$skipParentCreation = $previous;
        }
    }

    public function created(MiscModel $model)
    {
        if (self::$skipParentCreation) {
            return;
        }

        // Created a new sub entity? Create the parent entity.
        $model->createEntity();
    }

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

        Images::model($model)->cleanup();
    }

    public function saved(MiscModel $model)
    {
        EntityLogger::model($model);
    }
}
