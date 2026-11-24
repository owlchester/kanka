<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreNote;
use App\Http\Resources\NoteResource;
use App\Models\Campaign;
use App\Models\Note;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NoteApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->notes(), NoteResource::class);
    }

    public function show(Campaign $campaign, Note $note): NoteResource
    {
        return new NoteResource($this->viewModel($campaign, $note));
    }

    public function store(StoreNote $request, Campaign $campaign): NoteResource
    {
        return new NoteResource($this->storeModel($request, $campaign, config('entities.ids.note')));
    }

    public function update(StoreNote $request, Campaign $campaign, Note $note): NoteResource
    {
        return new NoteResource($this->updateModel($request, $campaign, $note));
    }

    public function destroy(Campaign $campaign, Note $note): JsonResponse
    {
        return $this->deleteModel($campaign, $note);
    }
}
