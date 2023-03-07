<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
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
            ->actionParams(['campaign' => $campaign->id])
            ->route('characters.organisations', [$campaign, $character]);

        $this->rows = $character
            ->organisationMemberships()
            ->sort(request()->only(['o', 'k']))
            ->with(['character', 'character.entity', 'organisation', 'organisation.entity', 'organisation.location', 'organisation.location.entity'])
            ->has('organisation')
            ->has('organisation.entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        $this->campaign = $campaign;
        return $this
            ->menuView($character,'organisations');
    }

    /**
     */
    public function map(Character $character)
    {
        return $this->menuView($character, 'map');
    }
}
