<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreJournal;
use App\Http\Resources\JournalResource;
use App\Models\Campaign;
use App\Models\Journal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class JournalApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->journals(), JournalResource::class);
    }

    public function show(Campaign $campaign, Journal $journal): JournalResource
    {
        return new JournalResource($this->viewModel($campaign, $journal));
    }

    public function store(StoreJournal $request, Campaign $campaign): JournalResource
    {
        return new JournalResource($this->storeModel($request, $campaign, config('entities.ids.journal')));
    }

    public function update(StoreJournal $request, Campaign $campaign, Journal $journal): JournalResource
    {
        return new JournalResource($this->updateModel($request, $campaign, $journal));
    }

    public function destroy(Campaign $campaign, Journal $journal): JsonResponse
    {
        return $this->deleteModel($campaign, $journal);
    }
}
