<?php

namespace App\Observers;

use App\Campaign;
use App\Character;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class CharacterObserver
{
    /**
     * @param Character $character
     */
    public function saving(Character $character)
    {
        $character->slug = str_slug($character->name, '');
        $character->campaign_id = Session::get('campaign_id');

        // Purity text
        $character->history = Purify::clean($character->history);

        if (request()->has('image')) {
            $path = request()->file('image')->store('characters', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $character->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $character->image = $path;
            }
        }
    }

    /**
     * @param Character $character
     */
    public function saved(Character $character)
    {
    }

    /**
     * @param Character $character
     */
    public function created(Character $character)
    {
    }

    /**
     * @param Character $character
     */
    public function deleted(Character $character)
    {
        if (!empty($character->image)) {
            // Delete
            Storage::disk('public')->delete($character->image);
        }
    }

    /**
     * @param Character $character
     */
    public function deleting(Character $character)
    {
        foreach ($character->items as $item) {
            $item->character_id = null;
            $item->save();
        }
    }
}
