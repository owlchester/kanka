<?php

namespace App\Observers;

use App\Campaign;
use App\Models\MiscModel;
use App\Models\Note;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class NoteObserver extends MiscObserver
{
    public function saving(MiscModel $model)
    {
        parent::saving($model);

        // Is Pinned hook for non-admin (who can't set is_pinned)
        if (!isset($model->is_pinned)) {
            $model->is_pinned = false;
        }
    }
}
