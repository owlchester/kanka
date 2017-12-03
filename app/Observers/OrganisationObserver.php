<?php

namespace App\Observers;

use App\Campaign;
use App\Models\MiscModel;
use App\Models\Organisation;
use App\Services\ImageService;
use App\Services\LinkerService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrganisationObserver extends MiscObserver
{
    /**
     * @param Organisation $organisation
     */
    public function deleting(MiscModel $organisation)
    {
        parent::deleting($organisation);

        foreach ($organisation->members as $member) {
            $member->delete();
        }
    }
}
