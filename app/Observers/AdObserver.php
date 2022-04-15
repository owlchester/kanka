<?php

namespace App\Observers;

use App\Facades\AdCache;
use App\Models\Ad;
use Illuminate\Support\Facades\DB;

class AdObserver
{
    /**
     * @param Ad $ad
     */
    public function deleting(Ad $ad)
    {
        AdCache::clear($ad->section);
    }

    public function created(Ad $ad)
    {
        AdCache::clear($ad->section);
    }

    public function updated(Ad $ad)
    {
        AdCache::clear($ad->section);

        if ($ad->is_active) {
            DB::table('ads')
                ->where('id', '<>', $ad->id)
                ->where('section', $ad->section)
                ->update(['is_active' => false]);
        }
    }
}
