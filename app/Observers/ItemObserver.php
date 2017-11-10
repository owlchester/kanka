<?php

namespace App\Observers;

use App\Campaign;
use App\Item;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Stevebauman\Purify\Facades\Purify;

class ItemObserver
{
    /**
     * @param Item $item
     */
    public function saving(Item $item)
    {
        $item->slug = str_slug($item->name, '');
        $item->campaign_id = Session::get('campaign_id');

        // Purity text
        $item->history = Purify::clean($item->history);
        $item->description = Purify::clean($item->description);

        // Handle image. Let's use a service for this.
        ImageService::handle($item, 'items');

        $nullable = ['location_id', 'character_id'];
        foreach ($nullable as $attr) {
            $item->setAttribute($attr, (request()->has($attr) ? request()->post($attr) : null));
        }
    }

    /**
     * @param Item $item
     */
    public function saved(Item $item)
    {
    }

    /**
     * @param Item $item
     */
    public function created(Item $item)
    {
    }

    /**
     * @param Item $item
     */
    public function deleted(Item $item)
    {
        ImageService::cleanup($item);
    }

    /**
     * @param Item $item
     */
    public function deleting(Item $item)
    {
        /*foreach ($item->members as $character) {
            $character->family_id = null;
            $character->save();
        }*/
    }
}
