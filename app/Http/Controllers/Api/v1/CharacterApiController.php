<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreCharacter as Request;
use App\Http\Resources\CharacterResource;
use App\Models\Campaign;
use App\Models\Character;
use App\Models\EntityType;
use App\Services\Models\SaveService;

class CharacterApiController extends ApiController
{
    public function __construct(protected SaveService $saveService)
    {}
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);

        return CharacterResource::collection($campaign
            ->characters()
            ->withApi()
            ->filter(request()->all())
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return CharacterResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $character->entity);

        return new CharacterResource($character);
    }

    /**
     * @return CharacterResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.character')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;

        $model = $this->saveService
            ->user(auth()->user())
            ->campaign($campaign)
            ->request($request)
            ->create($data, Character::class);

        return new CharacterResource($model);
    }

    /**
     * @return CharacterResource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $character->entity);

        $this->saveService
            ->user(auth()->user())
            ->campaign($campaign)
            ->request($request)
            ->model($character)
            ->update($request->all());

        return new CharacterResource($character);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Character $character)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $character->entity);
        $character->delete();

        return response()->json(null, 204);
    }
}
