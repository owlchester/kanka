<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
use App\Http\Controllers\Crud\CharacterController;
use App\Models\Campaign;
use App\Models\Character;

class CharacterSubController extends CharacterController
{
    /**
     */
    public function organisations(Campaign $campaign, Character $character)
    {
        $this->authCheck($character);

        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
            ->route('characters.organisations', [$character]);

        $this->rows = $character
            ->organisationMemberships()
            ->rows()
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->campaign($campaign)->datagridAjax();
        }

        return $this
            ->campaign($campaign)
            ->menuView($character, 'organisations');
    }

    /**
     */
    public function map(Campaign $campaign, Character $character)
    {
        return $this->campaign($campaign)->menuView($character, 'map');
    }
}
