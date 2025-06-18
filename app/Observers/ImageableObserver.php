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
            Images::model($model)
                // @phpstan-ignore-next-line
                ->folder($model->imageStoragePath())
                ->field($field)
                ->handle();
        }
        $model->saveQuietly();
    }

    public function deleted(Model $model): void
    {
        // @phpstan-ignore-next-line
        foreach ($model->getImageFields() as $field) {
            Images::model($model)
                ->field($field)
                ->cleanup();
        }
    }
}
