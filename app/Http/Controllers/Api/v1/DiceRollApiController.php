<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\DiceRoll;
use App\Http\Requests\StoreDiceRoll as Request;
use App\Http\Resources\DiceRoll as Resource;
use App\Http\Resources\DiceRollCollection as Collection;

class DiceRollApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return new Collection($campaign->diceRolls()->acl()->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param DiceRoll $diceRoll
     * @return Resource
     */
    public function show(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $diceRoll);
        return new Resource($diceRoll);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', DiceRoll::class);
        $model = DiceRoll::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param DiceRoll $diceRoll
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $diceRoll);
        $diceRoll->update($request->all());

        return new Resource($diceRoll);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param DiceRoll $diceRoll
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $diceRoll);
        $diceRoll->delete();

        return response()->json(null, 204);
    }
}
