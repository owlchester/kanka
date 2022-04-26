<?php

namespace App\Http\Controllers;

use App\Datagrids\Filters\CharacterItemFilter;
use App\Datagrids\Sorters\CharacterItemSorter;
use App\Datagrids\Sorters\CharacterOrganisationSorter;
use App\Datagrids\Sorters\CharacterQuestSorter;
use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Models\Family;
use App\Models\Location;
use App\Services\CharacterRelationMapBuilder;
use App\Services\RandomCharacterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CharacterSubController extends CharacterController
{
    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function profile(Character $character)
    {
        if (Auth::check()) {
            $this->authorize('view', $character);
        } else {
            $this->authorizeForGuest('read', $character);
        }

        return view('characters.profile')
            ->with('model', $character)
            ->with('name', $this->view);
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quests(Character $character)
    {
        return $this->datagridSorter(CharacterQuestSorter::class)
            ->menuView($character, 'quests');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Character $character)
    {
        return $this->datagridSorter(CharacterOrganisationSorter::class)
            ->menuView($character, 'organisations');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function items(Character $character)
    {
        return $this->datagridSorter(CharacterItemSorter::class)
            ->menuView($character, 'items');
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

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function diceRolls(Character $character)
    {
        return $this->menuView($character, 'dice_rolls');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function conversations(Character $character)
    {
        return $this->menuView($character, 'conversations');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function journals(Character $character)
    {
        return $this->menuView($character, 'journals');
    }
}
