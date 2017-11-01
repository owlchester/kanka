<?php

namespace App\Observers;

use App\Campaign;
use App\Organisation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class OrganisationObserver
{
    /**
     * @param Organisation $organisation
     */
    public function saving(Organisation $organisation)
    {
        $organisation->slug = str_slug($organisation->name, '');
        $organisation->campaign_id = Session::get('campaign_id');

        if (request()->has('image')) {
            $path = request()->file('image')->store('organisations', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $organisation->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $organisation->image = $path;
            }
        }
    }

    /**
     * @param Character $character
     */
    public function deleted(Organisation $organisation)
    {
        if (!empty($organisation->image)) {
            // Delete
            Storage::disk('public')->delete($organisation->image);
        }
    }

    /**
     * @param Organisation $organisation
     */
    public function deleting(Organisation $organisation)
    {
        foreach ($organisation->members as $member) {
            $member->delete();
        }
    }
}
