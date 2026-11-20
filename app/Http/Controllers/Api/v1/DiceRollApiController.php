<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreDiceRoll;
use App\Http\Resources\DiceRollResource;
use App\Models\Campaign;
use App\Models\DiceRoll;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DiceRollApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->diceRolls(), DiceRollResource::class);
    }

    public function show(Campaign $campaign, DiceRoll $diceRoll): DiceRollResource
    {
        return new DiceRollResource($this->viewModel($campaign, $diceRoll));
    }

    public function store(StoreDiceRoll $request, Campaign $campaign): DiceRollResource
    {
        return new DiceRollResource($this->storeModel($request, $campaign, config('entities.ids.dice_roll')));
    }

    public function update(StoreDiceRoll $request, Campaign $campaign, DiceRoll $diceRoll): DiceRollResource
    {
        return new DiceRollResource($this->updateModel($request, $campaign, $diceRoll));
    }

    public function destroy(Campaign $campaign, DiceRoll $diceRoll): JsonResponse
    {
        return $this->deleteModel($campaign, $diceRoll);
    }
}
