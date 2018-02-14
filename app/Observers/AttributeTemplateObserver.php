<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Character;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class AttributeTemplateObserver extends MiscObserver
{
    public function saving(MiscModel $model)
    {
        $model->is_private = false;
        parent::saving($model);
    }
}
