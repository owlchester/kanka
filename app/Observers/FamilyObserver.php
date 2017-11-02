<?php

namespace App\Observers;

use App\Campaign;
use App\Family;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class FamilyObserver
{
    /**
     * @param Family $family
     */
    public function saving(Family $family)
    {
        $family->slug = str_slug($family->name, '');
        $family->campaign_id = Session::get('campaign_id');

        // Purity text
        $family->history = Purify::clean($family->history);

        // Handle image. Let's use a service for this.
        ImageService::handle($family, 'families');
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

    /**
     * @param Character $character
     */
    public function deleted(Family $family)
    {
        ImageService::cleanup($family);
    }

    /**
     * @param Family $family
     */
    public function deleting(Family $family)
    {
        foreach ($family->members as $character) {
            $character->family_id = null;
            $character->save();
        }
    }
}
