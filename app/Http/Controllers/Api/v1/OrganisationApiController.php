<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\StoreOrganisation;
use App\Http\Resources\OrganisationResource;
use App\Models\Campaign;
use App\Models\Organisation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganisationApiController extends MiscApiController
{
    public function index(Campaign $campaign): AnonymousResourceCollection
    {
        return $this->listModels($campaign, $campaign->organisations(), OrganisationResource::class);
    }

    public function show(Campaign $campaign, Organisation $organisation): OrganisationResource
    {
        return new OrganisationResource($this->viewModel($campaign, $organisation));
    }

    public function store(StoreOrganisation $request, Campaign $campaign): OrganisationResource
    {
        return new OrganisationResource($this->storeModel($request, $campaign, config('entities.ids.organisation')));
    }

    public function update(StoreOrganisation $request, Campaign $campaign, Organisation $organisation): OrganisationResource
    {
        return new OrganisationResource($this->updateModel($request, $campaign, $organisation));
    }

    public function destroy(Campaign $campaign, Organisation $organisation): JsonResponse
    {
        return $this->deleteModel($campaign, $organisation);
    }
}
