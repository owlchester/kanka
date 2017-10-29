<?php

namespace App\Observers;

use App\Campaign;
use App\Character;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class CharacterObserver
{
    /**
     * @param Character $character
     */
    public function saving(Character $character)
    {
        $character->slug = str_slug($character->name, '');
        $character->campaign_id = Session::get('campaign_id');

        if (request()->has('image')) {
            $path = request()->file('image')->store('characters', 'public');
            if (!empty($path)) {
                $character->image = $path;
                $character->save();
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
}
