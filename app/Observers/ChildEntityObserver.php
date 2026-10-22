<?php

namespace App\Observers;

use App\Facades\EntityLogger;
use App\Models\MiscModel;

class ChildEntityObserver
{
    public function saved(MiscModel $model)
    {
        EntityLogger::model($model);
    }
}
