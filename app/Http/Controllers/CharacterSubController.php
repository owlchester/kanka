<?php

namespace App\Http\Controllers;

use App\Datagrids\Sorters\CharacterOrganisationSorter;
use App\Facades\Datagrid;
use App\Models\Character;
use Illuminate\Support\Facades\Auth;

class CharacterSubController extends CharacterController
{
    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function profile(Character $character)
    {
        $this->authCheck($character);

        return view('characters.profile')
            ->with('model', $character)
            ->with('name', $this->view);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Character $character)
    {
        $this->authCheck($character);

        Datagrid::layout(\App\Renderers\Layouts\Character\Organisation::class)
            ->route('characters.organisations', [$character]);

        $this->rows = $character
            ->organisations()
            ->sort(request()->only(['o', 'k']))
            ->with(['character', 'character.entity', 'organisation', 'organisation.entity', 'organisation.location', 'organisation.location.entity'])
            ->paginate();

        // Ajax Datagrid
        if (request()->ajax()) {
            return $this->datagridAjax();
        }

        return $this
            ->menuView($character, 'organisations');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function map(Character $character)
    {
        return $this->menuView($character, 'map');
    }
}
