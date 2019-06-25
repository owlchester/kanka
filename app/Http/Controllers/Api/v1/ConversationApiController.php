<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Conversation;
use App\Http\Requests\StoreConversation as Request;
use App\Http\Resources\Conversation as Resource;
use App\Http\Resources\ConversationCollection as Collection;

class ConversationApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return new Collection($campaign
            ->conversations()
            ->with(['messages', 'participants'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Conversation $conversation
     * @return Resource
     */
    public function show(Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $conversation);
        return new Resource($conversation);
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
        $this->authorize('create', Tag::class);
        $model = Tag::create($request->all());
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Conversation $conversation
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $conversation);
        $conversation->update($request->all());

        return new Resource($conversation);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Conversation $conversation
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Conversation $conversation)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $conversation);
        $conversation->delete();

        return response()->json(null, 204);
    }
}
