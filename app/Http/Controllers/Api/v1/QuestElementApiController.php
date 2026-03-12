<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreQuestElement as RequestElement;
use App\Http\Resources\QuestElementResource as Resource;
use App\Models\Campaign;
use App\Models\Quest;
use App\Models\QuestElement;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuestElementApiController extends ApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
     */
    public function index(Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest->entity);

        return Resource::collection($quest->elements()->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Quest $quest, QuestElement $questElement)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $quest->entity);

        return new Resource($questElement);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(RequestElement $requestElement, Campaign $campaign, Quest $quest)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest->entity);
        $data = $requestElement->all();
        $data['quest_id'] = $quest->id;
        $model = QuestElement::create($data);
        $model->refresh();

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(
        RequestElement $requestElement,
        Campaign $campaign,
        Quest $quest,
        QuestElement $questElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest->entity);
        $questElement->update($requestElement->all());

        return new Resource($questElement);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(
        Request $request,
        Campaign $campaign,
        Quest $quest,
        QuestElement $questElement
    ) {
        $this->authorize('access', $campaign);
        $this->authorize('update', $quest->entity);
        $questElement->delete();

        return response()->json(null, 204);
    }
}
