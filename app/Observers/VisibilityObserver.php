<?php

namespace App\Observers;

use App\Enums\Visibility;
use Illuminate\Database\Eloquent\Model;

class VisibilityObserver
{
    public function saving(Model $model)
    {
        if (empty($model->visibility_id)) {
            // @phpstan-ignore-next-line
            $model->visibility_id = Visibility::All;
        }
    }
}
