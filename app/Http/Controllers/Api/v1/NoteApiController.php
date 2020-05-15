<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\Note;
use App\Http\Requests\StoreNote as Request;
use App\Http\Resources\NoteResource as Resource;

class NoteApiController extends ApiController
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
            ->notes()
            ->with(['entity', 'entity.tags', 'entity.notes', 'entity.files', 'entity.events',
                'entity.relationships', 'entity.attributes'])
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @param Campaign $campaign
     * @param Note $note
     * @return Resource
     */
    public function show(Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $note);
        return new Resource($note);
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
        $this->authorize('create', Note::class);
        $model = Note::create($request->all());
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Note $note
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $note);
        $note->update($request->all());
        $this->crudSave($note);

        return new Resource($note);
    }

    /**
     * @param Request $request
     * @param Campaign $campaign
     * @param Note $note
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(\Illuminate\Http\Request $request, Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $note);
        $note->delete();

        return response()->json(null, 204);
    }
}
