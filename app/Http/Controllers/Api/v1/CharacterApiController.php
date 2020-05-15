<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Character;
use App\Http\Requests\StoreCharacter as Request;
use App\Http\Resources\CharacterResource;

class CharacterApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return CharacterResource::collection($campaign->characters()
            ->with([
                'entity', 'entity.tags', 'entity.notes', 'entity.files', 'entity.events',
                'entity.relationships', 'entity.attributes', 'characterTraits'
            ])
            ->lastSync(request()->get('lastSync'))
            ->paginate()
        );
    }

    /**
     * @param Campaign $campaign
     * @param Character $character
     * @return Resource
     */
    public function show(Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $character);
        return new CharacterResource($character);
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
        $this->authorize('create', Character::class);
        $model = Character::create($request->all());
        $this->crudSave($model);

        return new CharacterResource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Character $character
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $character);
        $character->update($request->all());
        $this->crudSave($character);

        return new CharacterResource($character);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Character $character
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $character);
        $character->delete();

        return response()->json(null, 204);
    }
}
