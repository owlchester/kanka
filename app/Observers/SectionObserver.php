<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Location;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class SectionObserver extends MiscObserver
{
    /**
     * @param MiscModel $model
     */
    public function saving(MiscModel $model)
    {
        parent::saving($model);
    }

    /**
     * @param Location $location
     */
    public function deleting(MiscModel $section)
    {
        parent::deleting($section);

        // Todo: remove this and update schema instead
        foreach ($section->characters as $character) {
            $character->section_id = null;
            $character->save();
        }

        foreach ($section->families as $family) {
            $family->section_id = null;
            $family->save();
        }

        foreach ($section->items as $item) {
            $item->section_id = null;
            $item->save();
        }

        foreach ($section->locations as $sub) {
            $sub->parent_section_id = null;
            $sub->save();
        }

        foreach ($section->organisations as $sub) {
            $sub->section_id = null;
            $sub->save();
        }
    }
}
