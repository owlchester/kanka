<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Character;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class CharacterObserver extends MiscObserver
{
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
