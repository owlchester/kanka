<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreDiceRoll as Request;
use App\Http\Resources\DiceRollResource as Resource;
use App\Models\Campaign;
use App\Models\DiceRoll;
use App\Models\EntityType;

class DiceRollApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return Resource::collection($campaign
            ->diceRolls()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $diceRoll->entity);

        return new Resource($diceRoll);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.dice_roll')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = DiceRoll::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $diceRoll->entity);
        $diceRoll->update($request->all());
        $this->crudSave($diceRoll);

        return new Resource($diceRoll);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, DiceRoll $diceRoll)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $diceRoll->entity);
        $diceRoll->delete();

        return response()->json(null, 204);
    }
}
