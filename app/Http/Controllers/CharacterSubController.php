<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Http\Requests\StoreCharacter;
use App\Models\Family;
use App\Models\Location;
use App\Services\CharacterRelationMapBuilder;
use App\Services\RandomCharacterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CharacterSubController extends CharacterController
{
    protected $characterRelationMapBuilder;

    public function __construct(CharacterRelationMapBuilder $characterRelationMapBuilder)
    {
        $this->characterRelationMapBuilder = $characterRelationMapBuilder;
    }

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

    public function mapData(Character $character)
    {
        $data = $this->characterRelationMapBuilder->build($character);
//        $data = [
//            'nodes' => [
//                [
//                    'id' => 'character-' . $character->id,
//                    'name' => $character->name,
//                    'group' => 1
//                ],
//                [
//                    'id' => 'character-' . ($character->id+1),
//                    'name' => $character->name . '1',
//                    'group' => 1
//                ],
//                [
//                    'id' => 'character-' . ($character->id+2),
//                    'name' => $character->name . '2',
//                    'group' => 2
//                ]
//            ],
//            'links' => [
//                [
//                    'source' => 'character-' . $character->id,
//                    'target' => 'character-' . ($character->id+1),
//                    'value' => 1,
//                ],
//                [
//                    'source' => 'character-' . $character->id,
//                    'target' => 'character-' . ($character->id+2),
//                    'value' => 3,
//                ],
//                [
//                    'source' => 'character-' . ($character->id+1),
//                    'target' => 'character-' . $character->id,
//                    'value' => 1,
//                ],
//            ]
//        ];
        return response()->json($data);
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
