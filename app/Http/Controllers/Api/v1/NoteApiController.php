<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreNote as Request;
use App\Http\Resources\NoteResource as Resource;
use App\Models\Campaign;
use App\Models\EntityType;
use App\Models\Note;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteApiController extends MiscApiController
{
    /**
     * @return AnonymousResourceCollection
     *
     * @throws AuthorizationException
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
     * @return resource
     */
    public function show(Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('view', $note->entity);

        return new Resource($note);
    }

    /**
     * @return resource
     *
     * @throws AuthorizationException
     */
    public function store(Request $request, Campaign $campaign)
    {
        $this->authorize('access', $campaign);
        $this->authorize('create', [EntityType::find(config('entities.ids.note')), $campaign]);

        $data = $request->all();
        $data['campaign_id'] = $campaign->id;
        $model = Note::create($data);
        $this->crudSave($model, $request->validated());

        return new Resource($model);
    }

    /**
     * @return resource
     */
    public function update(Request $request, Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('update', $note->entity);
        $note->update($request->all());
        $this->crudSave($note, $request->validated());

        return new Resource($note);
    }

    /**
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function destroy(Campaign $campaign, Note $note)
    {
        $this->authorize('access', $campaign);
        $this->authorize('delete', $note->entity);
        $note->delete();

        return response()->json(null, 204);
    }
}
