<?php

namespace App\Observers;

use App\Campaign;
use App\Models\Family;
use App\Models\MiscModel;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Session;

class FamilyObserver extends MiscObserver
{
    /**
     * @param Family $family
     */
    public function deleting(MiscModel $family)
    {
        parent::deleting($family);

        // Todo: handle this in schema, not in code!
        foreach ($family->members as $character) {
            $character->family_id = null;
            $character->save();
        }
    }
}
