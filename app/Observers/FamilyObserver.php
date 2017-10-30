<?php

namespace App\Observers;

use App\Campaign;
use App\Family;
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

        if (request()->has('banner')) {
            $path = request()->file('banner')->store('families', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $family->getOriginal('banner');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $family->banner = $path;
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

    /**
     * @param Character $character
     */
    public function deleted(Family $family)
    {
        if (!empty($family->banner)) {
            // Delete
            Storage::disk('public')->delete($family->banner);
        }
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
