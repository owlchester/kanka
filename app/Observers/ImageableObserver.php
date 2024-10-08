<?php

namespace App\Observers;

use App\Facades\Images;
use Illuminate\Database\Eloquent\Model;

class ImageableObserver
{
    public function saved(Model $model): void
    {
        // @phpstan-ignore-next-line
        foreach ($model->getImageFields() as $field) {
            // @phpstan-ignore-next-line
            Images::handle($model, $model->imageStoragePath(), $field);
        }
        $model->saveQuietly();
    }

    public function deleted(Model $model): void
    {
        // @phpstan-ignore-next-line
        foreach ($model->getImageFields() as $field) {
            Images::cleanup($model, $field);
        }
    }
}
