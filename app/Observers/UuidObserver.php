<?php

namespace App\Observers;

use App\Models\Plugin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UuidObserver
{
    /**
     * @param Model|Plugin $model
     * @return void
     */
    public function creating(Model $model)
    {
        $model->uuid = Str::uuid();
    }
}
