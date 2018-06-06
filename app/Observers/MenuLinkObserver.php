<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Item;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class MenuLinkObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        $model->campaign_id = Session::get('campaign_id');
        $model->icon = '';

        // Is private hook for non-admin (who can't set is_private)
        if (!isset($model->is_private)) {
            $model->is_private = false;
        }
    }
}
