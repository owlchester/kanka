<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Conversation;
use App\Http\Requests\StoreConversation as Request;
use App\Http\Resources\ConversationResource as Resource;
use App\Models\EntityType;

class ConversationApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->conversations()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation->entity);
        return new Resource($conversation);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', EntityType::find(config('entities.ids.conversation')));

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        /** @var Conversation $model */
        $model = Conversation::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation->entity);
        $conversation->update($request->all());
        $this->crudSave($conversation);

        return new Resource($conversation);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $conversation->entity);
        $conversation->delete();

        return response()->json(null, 204);
    }
}
