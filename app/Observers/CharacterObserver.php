<?php

namespace App\Observers;

use App\Campaign;
use App\Character;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
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

        // Handle image. Let's use a service for this.
        ImageService::handle($character, 'characters');

        $nullable = ['location_id', 'family_id'];
        foreach ($nullable as $attr) {
            $character->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
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
        ImageService::cleanup($character);
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
