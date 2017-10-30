<?php

namespace App\Observers;

use App\Campaign;
use App\Item;
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
        $item->history = Purify::clean($item->history);

        if (request()->has('image')) {
            $path = request()->file('image')->store('items', 'public');
            if (!empty($path)) {
                // Remove old
                $original = $item->getOriginal('image');
                if (!empty($original)) {
                    // Delete
                    Storage::disk('public')->delete($original);
                }
                $item->image = $path;
            }
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
        if (!empty($item->image)) {
            // Delete
            Storage::disk('public')->delete($item->image);
        }
    }
}
