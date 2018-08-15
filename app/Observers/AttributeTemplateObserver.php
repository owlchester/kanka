<?php

namespace App\Observers;

use App\Models\MiscModel;

class AttributeTemplateObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->is_private = false;
        parent::saving($model);
    }
}
