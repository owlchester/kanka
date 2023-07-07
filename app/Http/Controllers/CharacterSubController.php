<?php

namespace App\Http\Controllers;

use App\Facades\Datagrid;
use App\Models\Character;

class CharacterSubController extends CharacterController
{
    /**
     */
    public function organisations(Character $character)
    {
        $this->authCheck($character);

        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
            ->route('characters.organisations', [$character]);

        $this->rows = $character
            ->organisationMemberships()
            ->sort(request()->only(['o', 'k']), ['name' => 'asc'])
            ->with(['character', 'character.entity', 'organisation', 'organisation.entity', 'organisation.location', 'organisation.location.entity'])
            ->has('organisation')
            ->has('organisation.entity')
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($character, 'organisations');
    }

    /**
     */
    public function map(Character $character)
    {
        return $this->menuView($character, 'map');
    }
}
