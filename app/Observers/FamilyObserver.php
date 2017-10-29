<?php

namespace App\Observers;

use App\Campaign;
use App\Family;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class FamilyObserver
{
    /**
     * @param Family $family
     */
    public function saving(Family $family)
    {
        $family->slug = str_slug($family->name, '');
        $family->campaign_id = Session::get('campaign_id');

        if (request()->has('image')) {
            $path = request()->file('image')->store('families', 'public');
            if (!empty($path)) {
                $family->image = $path;
            }
        }
    }

    /**
     * @param Family $family
     */
    public function saved(Family $family)
    {
    }

    /**
     * @param Family $family
     */
    public function created(Family $family)
    {
    }
}
