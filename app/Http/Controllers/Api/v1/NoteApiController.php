<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Note;
use App\Http\Requests\StoreNote as Request;
use App\Http\Resources\NoteResource as Resource;

class NoteApiController extends ApiController
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        return Resource::collection($campaign
            ->notes()
            ->filter(request()->all())
            ->withApi()
            ->lastSync(request()->get('lastSync'))
            ->paginate());
    }

    /**
     * @return Resource
     */
    public function show(Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $note->entity);
        return new Resource($note);
    }

    /**
     * @return Resource
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', EntityType::find(config('entities.ids.note')));

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Note::create($data);
        $this->crudSave($model);
        return new Resource($model);
    }

    /**
     * @return Resource
     */
    public function update(Request $request, Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $note->entity);
        $note->update($request->all());
        $this->crudSave($note);

        return new Resource($note);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $note->entity);
        $note->delete();

        return response()->json(null, 204);
    }
}
