<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidObserver
{
    public function creating(Model $model)
    {
        $model->uuid = Str::uuid();
    }
}
