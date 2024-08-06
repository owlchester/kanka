<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugObserver
{
    public function saving(Model $model)
    {
        // @phpstan-ignore-next-line
        $model->slug = Str::slug($model->name, '');
    }
}
