<?php

namespace App\Observers;

use App\Models\Concerns\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidObserver
{
    /**
     * @param Model|Uuid $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->uuid = Str::uuid();
    }
}
