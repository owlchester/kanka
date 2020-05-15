<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Journal;
use App\Http\Requests\StoreJournal as Request;
use App\Http\Resources\JournalResource as Resource;

class JournalApiController extends ApiController
{
    /**
     * @param Campaign $campaign
     * @return Collection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->journals()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files',
                'entity.events', 'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Journal $journal
     * @return Resource
     */
    public function show(Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $journal);
        return new Resource($journal);
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
        $this->authorize('create', Journal::class);
        $model = Journal::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Journal $journal
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $journal);
        $journal->update($request->all());
        $this->crudSave($journal);

        return new Resource($journal);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Journal $journal
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Journal $journal)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $journal);
        $journal->delete();

        return response()->json(null, 204);
    }
}
