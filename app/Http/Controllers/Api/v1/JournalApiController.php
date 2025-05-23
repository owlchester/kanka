<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreJournal as Request;
use App\Http\Resources\JournalResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Journal;

class JournalApiController extends ApiController
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
            ->journals()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return resource
     */
    public function show(Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $journal->entity);

        return new Resource($journal);
    }

    /**
     * @return resource
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.journal')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Journal::create($data);
        $this->crudSave($model);

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $journal->entity);
        $journal->update($request->all());
        $this->crudSave($journal);

        return new Resource($journal);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $journal->entity);
        $journal->delete();

        return response()->json(null, 204);
    }
}
