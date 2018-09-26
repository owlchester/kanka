<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Models\Family;
use App\Models\Location;
use App\Services\RandomCharacterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterSubController extends CharacterController
{
    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function quests(Character $character)
    {
        return $this->menuView($character, 'quests');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function organisations(Character $character)
    {
        return $this->menuView($character, 'organisations');
    }

    /**
     * @param Character $character
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function items(Character $character)
    {
        return $this->menuView($character, 'items');
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
